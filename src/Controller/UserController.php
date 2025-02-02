<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\FormTemplate;
use App\Entity\FormResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\FormController;
use App\Service\CalendarGenerator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;

#[Route('/user')]
class UserController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private $calendarGenerator;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, CalendarGenerator $calendarGenerator, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->calendarGenerator = $calendarGenerator;
        $this->security = $security;
    }

    public function dashboard(): Response
    {
        $user = $this->getUser();
        $calendar = $this->calendarGenerator->generateCalendar();
        
        // Récupérer tous les modèles de formulaires disponibles
        $formTemplates = $this->entityManager->getRepository(FormTemplate::class)->findAll();
        
        // Initialiser un tableau pour stocker les derniers prospects pour chaque formulaire
        $latestProspects = [];
        
        // Récupérer les 4 premières réponses de chaque formulaire
        foreach ($formTemplates as $formTemplate) {
            // Modifier la requête pour filtrer par utilisateur
            $responses = $this->entityManager->getRepository(FormResponse::class)->findBy(
                ['FormTemplateTitle' => $formTemplate, 'user' => $user],
                ['Date' => 'DESC'],
                4 // Limiter le nombre de résultats à 4
            );
    
            // Garder seulement les derniers prospects
            $latestProspects[$formTemplate->getId()] = array_slice($responses, 0, 4);
        }
    
        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            'formTemplates' => $formTemplates,
            'latestProspects' => $latestProspects,
            'calendar' => $calendar,
        ]);
    }

    #[Route('/user/show-form/{userId}/{formTemplateId}', name: 'app_user_show_form')]
    public function showForm(int $userId, int $formTemplateId, FormController $formController): Response
{
    // Récupérer l'utilisateur et le modèle de formulaire depuis la base de données
    $user = $this->entityManager->getRepository(User::class)->find($userId);
    $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

    // Appeler l'action showForm du FormController
    return $formController->showForm($formTemplate);
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

    $user = $this->getUser();

    // Récupérer les réponses dans la base de données pour l'utilisateur actuel
    $formResponses = $this->entityManager->getRepository(FormResponse::class)->findBy([
        'FormTemplateTitle' => $formTemplate,
        'user' => $user,
    ]);

    // Regrouper les réponses par date et formulaire
    $groupedResponses = [];
    foreach ($formResponses as $formResponse) {
        $date = $formResponse->getDate()->format('Y-m-d H:i:s');
        $groupedResponses[$date][] = $formResponse;
    }

      // Récupérer le dernier formulaire
      $lastResponse = end($formResponses);

    return $this->render('user/show_answers.html.twig', [
        'formTemplate' => $formTemplate,
        'groupedResponses' => $groupedResponses,
        'formResponses' => $formResponses,
        'lastResponse' => $lastResponse,
    ]);
}

#[Route('/user/show-responses/{formTemplateId}/{date}', name: 'app_user_show_responses', methods: ['GET'])]
public function showResponses(int $formTemplateId, string $date): Response
{
    $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
    $user = $this->getUser();

// Convertir la date fournie dans l'URL en objet DateTimeImmutable
$formattedDate = new \DateTimeImmutable($date);

// Récupérer les réponses pour le formulaire et la date spécifiques de l'utilisateur actuel
$formResponses = $this->entityManager->getRepository(FormResponse::class)->findBy([
    'FormTemplateTitle' => $formTemplate,
    'Date' => $formattedDate, // Utilisation de l'objet DateTimeImmutable
    'user' => $user,
]);
   // Initialiser les variables de date de mandat et de vente
   $mandatDate = null;
   $venteDate = null;
   $responseDate = null;
   $relanceDate = null;

      // Parcourir les réponses de formulaire pour extraire les dates de mandat et de vente
      foreach ($formResponses as $response) {
        if ($response->getMandatDate() !== null) {
            $mandatDate = $response->getMandatDate();
        }
        if ($response->getVenteDate() !== null) {
            $venteDate = $response->getVenteDate();
        }
        if ($response->getResponseDate() !== null) {
            $responseDate = $response->getResponseDate();
        }
        if ($response->getRelanceDate() !== null) {
            $relanceDate = $response->getRelanceDate();
        }
    }
    
    return $this->render('user/show_response.html.twig', [
        'formTemplate' => $formTemplate,
        'formResponses' => $formResponses,
        'date' => $date,
        'mandatDate' => $mandatDate,
        'venteDate' => $venteDate,
        'responseDate' => $responseDate,
        'relanceDate' => $relanceDate,
    ]);
}

#[Route('/user/save-mandat-date', name: 'app_user_save_mandat_date', methods: ['POST'])]
public function saveMandatDate(Request $request): Response
{
    // Récupérer les données du formulaire
    $formTemplateId = $request->request->get('formTemplateId');
    $date = $request->request->get('date');

    // Récupérer l'utilisateur
    $user = $this->getUser();

    // Récupérer le formulaire
    $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

    // Mettre à jour la date de mandat dans l'entité FormResponse
    $formResponse = $this->entityManager->getRepository(FormResponse::class)->findOneBy([
        'FormTemplateTitle' => $formTemplate,
        'Date' => new \DateTimeImmutable($date),
        'user' => $user,
    ]);
    $formResponse->setMandatDate(new \DateTime());

    // Enregistrer les changements
    $this->entityManager->flush();

// Redirection vers la page de suivi des réponses
return $this->redirectToRoute('app_user_show_responses', [
    'formTemplateId' => $formTemplateId,
    'date' => $date,
]);
}

#[Route('/user/save-vente-date', name: 'app_user_save_vente_date', methods: ['POST'])]
public function saveVenteDate(Request $request): Response
{
     // Récupérer les données du formulaire
     $formTemplateId = $request->request->get('formTemplateId');
     $date = $request->request->get('date');
 
     // Récupérer l'utilisateur
     $user = $this->getUser();
 
     // Récupérer le formulaire
     $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
 
     // Mettre à jour la date de vente dans l'entité FormResponse
     $formResponse = $this->entityManager->getRepository(FormResponse::class)->findOneBy([
         'FormTemplateTitle' => $formTemplate,
         'Date' => new \DateTimeImmutable($date),
         'user' => $user,
     ]);
     $formResponse->setVenteDate(new \DateTime());
 
     // Enregistrer les changements
     $this->entityManager->flush();
 

       // Redirection vers la page de suivi des réponses
       return $this->redirectToRoute('app_user_show_responses', [
        'formTemplateId' => $formTemplateId,
        'date' => $date,
    ]);
}

#[Route('/user/save-response-date', name: 'app_user_save_response_date', methods: ['POST'])]
public function saveResponseDate(Request $request): Response
{
     // Récupérer les données du formulaire
     $formTemplateId = $request->request->get('formTemplateId');
     $date = $request->request->get('date');
 
     // Récupérer l'utilisateur
     $user = $this->getUser();
 
     // Récupérer le formulaire
     $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
 
     // Mettre à jour la date de vente dans l'entité FormResponse
     $formResponse = $this->entityManager->getRepository(FormResponse::class)->findOneBy([
         'FormTemplateTitle' => $formTemplate,
         'Date' => new \DateTimeImmutable($date),
         'user' => $user,
     ]);
     $formResponse->setResponseDate(new \DateTime());
 
     // Enregistrer les changements
     $this->entityManager->flush();
 
       // Redirection vers la page de suivi des réponses
       return $this->redirectToRoute('app_user_show_responses', [
        'formTemplateId' => $formTemplateId,
        'date' => $date,
    ]);
}

#[Route('/user/save-relance-date', name: 'app_user_save_relance_date', methods: ['POST'])]
public function saveRelanceDate(Request $request): Response
{
     // Récupérer les données du formulaire
     $formTemplateId = $request->request->get('formTemplateId');
     $date = $request->request->get('date');
 
     // Récupérer l'utilisateur
     $user = $this->getUser();
 
     // Récupérer le formulaire
     $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);
 
     // Mettre à jour la date de vente dans l'entité FormResponse
     $formResponse = $this->entityManager->getRepository(FormResponse::class)->findOneBy([
         'FormTemplateTitle' => $formTemplate,
         'Date' => new \DateTimeImmutable($date),
         'user' => $user,
     ]);
     $formResponse->setRelanceDate(new \DateTime());
 
     // Enregistrer les changements
     $this->entityManager->flush();

       // Redirection vers la page de suivi des réponses
       return $this->redirectToRoute('app_user_show_responses', [
        'formTemplateId' => $formTemplateId,
        'date' => $date,
    ]);
}

}