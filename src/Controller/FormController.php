<?php

namespace App\Controller;

use App\Entity\FormTemplate;
use App\Entity\FormQuestion;
use App\Entity\FormResponse;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Service\EmailService;
use App\Repository\FormTemplateRepository;

class FormController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private EmailService $emailService;

    public function __construct(EntityManagerInterface $entityManager, EmailService $emailService)
    {
        $this->entityManager = $entityManager;
        $this->emailService = $emailService;
    }

    #[Route('/form/{formTemplateId}', name: 'form_show')]
    public function showForm($formTemplateId): Response
    {
        $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

        if (!$formTemplate) {
            throw $this->createNotFoundException('Formulaire non trouvé');
        }

        $questions = $formTemplate->getFormQuestions();
        $introMessage = $formTemplate->getIntroMessage();

        return $this->render('form/show.html.twig', [
            'formTemplate' => $formTemplate,
            'questions' => $questions,
            'introMessage' => $introMessage,
        ]);
    }

    #[Route('/submit/{formTemplateId}', name: 'submit', methods: ['POST'])]
    public function FormSubmission(Request $request, int $formTemplateId, EmailService $emailService, FormTemplateRepository $formTemplateRepository): Response
    {
        try {
            // Récupérer les données brutes du formulaire
            $formData = $request->request->all();
    
            // Récupérer le formulaire associé aux réponses
            $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
    
            // Récupérer le message de remerciement associé au formulaire
            $thankYouMessage = $formTemplate->getThankYouMessage();
    
            // Vérifier si un utilisateur est connecté et s'il s'agit d'un objet User
            $user = $this->getUser();
            if (!$user instanceof User) {
                throw $this->createAccessDeniedException('Utilisateur non connecté ou non autorisé');
            }
    
            // Récupérer la date actuelle
            $currentDate = new \DateTimeImmutable();
    
            // Générer l'identifiant unique pour cette soumission de formulaire
            $formResponseId = $currentDate->format('YmdHis') . $formTemplateId . $user->getId();
    
            // Récupérer les informations sur les questions obligatoires du formulaire
            $requiredQuestionIds = $formTemplateRepository->findRequiredQuestionIds($formTemplateId);
    
            // Récupérer les réponses dans la base de données
            foreach ($formData['form_responses'] as $formQuestionId => $response) {
                // Vérifier si la question est obligatoire
                $isRequired = in_array($formQuestionId, $requiredQuestionIds);
    
                // Vérifier si la réponse est vide pour les questions obligatoires uniquement
                if ($isRequired && empty($response)) {
                    throw new \Exception('La réponse à la question ne peut pas être vide');
                }
    
                // Créer une nouvelle instance de l'entité FormReponse
                $formReponse = new FormResponse();
    
                // Set la valeur de l'identifiant unique
                $formReponse->setFormResponseId($formResponseId);
    
                // Si la réponse est un tableau, il s'agit des checkbox
                if (is_array($response)) {
                    // Convertir le tableau de réponses en une chaîne de caractères séparée par des virgules
                    $responseText = implode(',', $response);
    
                    // Set la réponse dans l'entité
                    $formReponse->setFormTextAnswer($responseText);
                } else {
                    // Set la réponse dans l'entité
                    $formReponse->setFormTextAnswer($response);
                }
    
                // Associer le formulaire aux réponses
                $formReponse->setFormTemplateTitle($formTemplate);
                $formReponse->setFormQuestion($this->entityManager->getReference(FormQuestion::class, $formQuestionId));
    
                // Ajouter la date actuelle
                $formReponse->setDate($currentDate);
    
                // Associer l'utilisateur à la réponse
                $formReponse->setUser($user);
    
                // Persist l'entité dans l'EntityManager
                $this->entityManager->persist($formReponse);
            }
    
            // Flush les changements dans la base de données
            $this->entityManager->flush();

            // Récupérer l'email de redirection de l'utilisateur s'il est défini
            $redirectedEmail = $user->getEmailRedirection();

            // Récupérer l'email de l'utilisateur
            $userEmail = $user->getEmail();

            // Utiliser l'email de redirection si disponible
            $recipientEmail = $redirectedEmail ?? $userEmail;

        // Construire le texte de l'email en fonction de la présence ou de l'absence de l'email de redirection
        $emailText = '';
        if ($redirectedEmail) {
            $emailText = "Bonjour, vous avez reçu une nouvelle soumission de formulaire via une redirection d'email de $userEmail : veuillez vous connecter à sa session pour récupérer la réponse.";
        } else {
            $emailText = "Bonjour, une nouvelle réponse à l'un de vos formulaires a été soumis.";
        }

              // Envoyer l'email en utilisant le service EmailService
        $emailService->sendEmail($recipientEmail, $emailText);
    
            // Passer le message de remerciement et les données de l'utilisateur à la vue de la page de remerciement
            return $this->render('form/thank.html.twig', [
                'user'=> $user,
                'thankYouMessage' => $thankYouMessage,
            ]);
        } catch (\Throwable $e) {
            // Gérer l'erreur
            throw $e;
        }
    }

    #[Route('/user/close-form/{formTemplateId}/{date}', name: 'app_user_close_form', methods: ['POST'])]
    public function DeleteForm(int $formTemplateId, string $date): RedirectResponse
    {
        // Récupérer le modèle de formulaire et l'utilisateur depuis la base de données
        $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
    
        // Récupérer les réponses dans la base de données
        $formResponses = $this->entityManager->getRepository(FormResponse::class)->findBy([
            'FormTemplateTitle' => $formTemplate,
            'Date' => new \DateTimeImmutable($date),
   
        ]);
    
        // Regrouper les réponses par date, formulaire et utilisateur
        $groupedResponses = [];
        foreach ($formResponses as $formResponse) {
            $formattedDate = $formResponse->getDate()->format('Y-m-d H:i:s');
            $key = $formattedDate . '_' . $formTemplateId;
            $groupedResponses[$key][] = $formResponse;
        }
    
        // Supprimer les réponses spécifiques
        foreach ($formResponses as $formResponse) {
            $this->entityManager->remove($formResponse);
        }
    
        $this->entityManager->flush();
       
        return $this->redirectToRoute('user_dashboard');
    }
}    