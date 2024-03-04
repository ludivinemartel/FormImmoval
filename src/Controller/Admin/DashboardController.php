<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\FormTemplate;
use App\Entity\FormResponse;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\FormTemplateRepository;
use App\Repository\FormResponseRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\EntityManagerInterface;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private FormTemplateRepository $formTemplateRepository,
        private FormResponseRepository $formResponseRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        // Récupérer le nombre total de modèles de formulaire
        $totalFormTemplates = $this->formTemplateRepository->count([]);

        // Récupérer le nombre total de réponses soumises
        $totalFormResponses = $this->getTotalFormResponses();

        return $this->render('admin/dashboard.html.twig', [
            'totalFormTemplates' => $totalFormTemplates,
            'totalFormResponses' => $totalFormResponses,
        ]);
    }

    private function getTotalFormResponses(): int
    {
        // Récupérer les réponses aux formulaires
        $formResponses = $this->entityManager->getRepository(FormResponse::class)->findAll();
    
        // Initialiser un tableau pour stocker les clés uniques
        $uniqueForms = [];
    
        // Parcourir les réponses et les regrouper par date, modèle de formulaire et utilisateur
        foreach ($formResponses as $formResponse) {
            // Récupérer la date, le modèle de formulaire et l'utilisateur
            $formattedDate = $formResponse->getDate()->format('Y-m-d');
            $formTemplateId = $formResponse->getFormTemplateTitle()->getId();
            $userId = $formResponse->getUser()->getId();
    
            // Créer une clé unique en concaténant la date, le modèle de formulaire et l'utilisateur
            $uniqueFormKey = $formattedDate . '_' . $formTemplateId . '_' . $userId;
    
            // Si la clé unique n'existe pas déjà, l'ajouter à notre tableau des clés uniques
            if (!isset($uniqueForms[$uniqueFormKey])) {
                $uniqueForms[$uniqueFormKey] = true;
            }
        }

        // Compter le nombre d'entrées dans le tableau des clés uniques pour obtenir le nombre total de formulaires soumis
        $totalFormResponses = count($uniqueForms);
    
        return $totalFormResponses;
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');

        yield MenuItem::section('Formulaires');
        yield MenuItem::subMenu('Formulaires', 'fas fa-pen')->setSubItems([
            MenuItem::linkToCrud('Voir les modèles de formulaires', 'fas fa-eye', FormTemplate::class),
            MenuItem::linkToCrud('Créer un modèle de formulaire', 'fas fa-plus', FormTemplate::class)
            ->setAction('new'),
        ]);

        yield MenuItem::section('Négociateurs');
        yield MenuItem::subMenu('Négociateurs', 'fas fa-user')->setSubItems([
            MenuItem::linkToCrud('Voir négociateurs', 'fas fa-eye', User::class),
            MenuItem::linkToCrud('Ajouter un négociateur', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
        ]);
    }
}
