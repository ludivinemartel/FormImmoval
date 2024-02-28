<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\FormTemplate;
use App\Entity\FormReponse;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\QuestionnaireController;
use App\Service\CalendarGenerator;



#[Route('/user')]
class UserController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private $calendarGenerator;

    public function __construct(EntityManagerInterface $entityManager, CalendarGenerator $calendarGenerator)
    {
        $this->entityManager = $entityManager;
        $this->calendarGenerator = $calendarGenerator;
    }

    public function dashboard(): Response
    {
        $user = $this->getUser();
        $calendar = $this->calendarGenerator->generateCalendar();
        
        // Récupérer tous les modèles de formulaires disponibles
        $formTemplates = $this->entityManager->getRepository(FormTemplate::class)->findAll();
        
        // Initialiser un tableau pour stocker les 2 derniers prospects pour chaque formulaire
        $latestProspects = [];
        
        // Récupérer les 4 premières réponses pour chaque formulaire
        foreach ($formTemplates as $formTemplate) {
            $responses = $this->entityManager->getRepository(FormReponse::class)->findBy(
                ['FormTemplateTitle' => $formTemplate, 'user' => $user],
                ['Date' => 'DESC'],
                4 // Limiter le nombre de résultats à 4
            );
    
            // Garder seulement les 2 derniers prospects
            $latestProspects[$formTemplate->getId()] = array_slice($responses, 0, 4);
        }
    
        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            'formTemplates' => $formTemplates,
            'latestProspects' => $latestProspects,
            'calendar' => $calendar,
        ]);
    }
    

    #[Route('/add-form-template/{userId}/{formTemplateId}', name: 'app_user_add_form_template', methods: ['GET'])]
    public function addFormTemplateToUser(EntityManagerInterface $entityManager, $userId, $formTemplateId): Response
    {
        $user = $entityManager->getRepository(User::class)->find($userId);
        $formTemplate = $entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

        if ($user && $formTemplate) {
            $user->addFormTemplate($formTemplate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_dashboard');
    }

    #[Route('/user/show-form/{userId}/{formTemplateId}', name: 'app_user_show_form')]
    public function showForm($userId, $formTemplateId, QuestionnaireController $questionnaireController): Response
{
    // Récupérer l'utilisateur et le modèle de formulaire depuis la base de données
    $user = $this->entityManager->getRepository(User::class)->find($userId);
    $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

    // Appeler l'action showForm du QuestionnaireController
    return $questionnaireController->showForm($formTemplate);
}

#[Route('/user/show-answers/{formTemplateId}', name: 'app_user_show_answers', methods: ['GET'])]
public function showAnswers(int $formTemplateId): Response
{
    // Récupérer le modèle de formulaire depuis la base de données
    $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

    // Vérifier si le formulaire existe
    if (!$formTemplate) {
        throw $this->createNotFoundException('Form Template not found');
    }

    // Récupérer les réponses dans la base de données
    $formResponses = $this->entityManager->getRepository(FormReponse::class)->findBy([
        'FormTemplateTitle' => $formTemplate,
    ]);

    // Regrouper les réponses par date et formulaire
    $groupedResponses = [];
    foreach ($formResponses as $formResponse) {
        $date = $formResponse->getDate()->format('Y-m-d H:i:s');
        $groupedResponses[$date][] = $formResponse;
    }

    return $this->render('user/show_answers.html.twig', [
        'formTemplate' => $formTemplate,
        'groupedResponses' => $groupedResponses,
        'formResponses' => $formResponses,
    ]);
}

#[Route('/user/show-responses/{formTemplateId}/{date}', name: 'app_user_show_responses', methods: ['GET'])]
public function showResponses(int $formTemplateId, string $date): Response
{
    $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
  

    // Récupérer les réponses pour le formulaire et la date spécifiques
    $formResponses = $this->entityManager->getRepository(FormReponse::class)->findBy([
        'FormTemplateTitle' => $formTemplate,
        'Date' => new \DateTimeImmutable($date),
    ]);

    return $this->render('user/show_response.html.twig', [
        'formTemplate' => $formTemplate,
        'formResponses' => $formResponses,
        'date' => $date,
 
    ]);
}

}