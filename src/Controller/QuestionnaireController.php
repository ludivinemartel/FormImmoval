<?php

namespace App\Controller;

use App\Entity\FormTemplate;
use App\Entity\FormQuestion;
use App\Entity\FormReponse;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class QuestionnaireController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/questionnaire/{formTemplateId}', name: 'questionnaire_show')]
    public function showForm($formTemplateId): Response
    {
        $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

        if (!$formTemplate) {
            throw $this->createNotFoundException('Formulaire non trouvé');
        }

        $questions = $formTemplate->getFormQuestions();

        return $this->render('form/show.html.twig', [
            'formTemplate' => $formTemplate,
            'questions' => $questions,
        ]);
    }

    #[Route('/submit/{formTemplateId}', name: 'submit', methods: ['POST'])]
    public function FormSubmission(Request $request, int $formTemplateId): Response
    {
        try {
            // Récupérer les données brutes du formulaire
            $formData = $request->request->all();
    
            // Récupérer le formulaire associé aux réponses
            $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
    
            // Vérifier si le formulaire existe
            if (!$formTemplate) {
                throw $this->createNotFoundException('Formulaire non trouvé');
            }
    
            // Récupérer l'utilisateur connecté
            $user = $this->getUser();
    
            // Vérifier si un utilisateur est connecté
            if (!$user) {
                throw $this->createAccessDeniedException('Utilisateur non connecté');
            }
    
            // Récupérer la date actuelle
            $currentDate = new \DateTimeImmutable();
    
            // Récupérer les réponses dans la base de données
            foreach ($formData['form_responses'] as $formQuestionId => $responseText) {
                // Créer une nouvelle instance de l'entité FormReponse
                $formReponse = new FormReponse();
    
                // Set la réponse dans l'entité
                $formReponse->setFormTextAnswer($responseText);
    
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

            // Passer le nom et le prénom à la vue de la page de remerciement
            return $this->render('form/thank.html.twig', [
               'user'=> $user
            ]);
        } catch (\Throwable $e) {
            // Gérer l'erreur
            throw $e;
        }
    }


    #[Route('/user/close-form/{formTemplateId}/{date}', name: 'app_user_close_form', methods: ['POST'])]
    public function closeForm(int $formTemplateId, string $date): RedirectResponse
    {
        // Récupérer le modèle de formulaire et l'utilisateur depuis la base de données
        $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
    
        // Récupérer les réponses dans la base de données
        $formResponses = $this->entityManager->getRepository(FormReponse::class)->findBy([
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