<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\FormTemplate;
use App\Controller\QuestionnaireController;
use App\Entity\FormReponse;

#[Route('/user')]
class UserController extends AbstractController
{

    private EntityManagerInterface $entityManager;
 

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dashboard', name: 'user_dashboard')]
    public function dashboard(): Response
    {
        $user = $this->getUser();
        // Récupérer tous les modèles de formulaires pour lesquels l'utilisateur a accès
        $formTemplates = $this->entityManager->getRepository(FormTemplate::class)->findAll();

        return $this->render('user/dashboard.html.twig', [
            'user' => $user,
            'formTemplates' => $formTemplates,
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


    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
