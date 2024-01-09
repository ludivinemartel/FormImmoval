<?php

namespace App\Controller;

use App\Entity\FormTemplate;
use App\Entity\FormQuestion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\FormReponse;


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

            // Récupérer les réponses dans la base de données
            foreach ($formData['form_responses'] as $formQuestionId => $responseText) {
                // Créer une nouvelle instance de l'entité FormReponse
                $formReponse = new FormReponse();

                // Set la réponse dans l'entité
                $formReponse->setFormTextAnswer($responseText);

                // Associer le formulaire aux réponses
                $formReponse->setFormTemplateTitle($formTemplate);

                $formReponse->setFormQuestion($this->entityManager->getReference(FormQuestion::class, $formQuestionId));

                // Persist l'entité dans l'EntityManager
                $this->entityManager->persist($formReponse);
            }

            // Flush les changements dans la base de données
            $this->entityManager->flush();

            // Rediriger ou afficher une page de confirmation
            return $this->render('home/index.html.twig');
        } catch (\Throwable $e) {
            // Gérer l'erreur
            throw $e;
        }
    }
}
