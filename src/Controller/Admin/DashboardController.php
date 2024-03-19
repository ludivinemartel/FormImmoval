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
    
        // Récupérer les totaux mis à jour
        $totals = $this->getTotalFormResponses();

        // Récupérer le nombre de soumissions du formulaire "Formulaire d'estimation" ce mois-ci
        $estimationFormSubmissionsThisMonth = $this->formResponseRepository->countEstimationFormSubmissionsThisMonth();

        return $this->render('admin/dashboard.html.twig', [
            'totalFormTemplates' => $totalFormTemplates,
            'totalFormResponses' => $totals['totalFormResponses'],
            'totalMandats' => $totals['totalMandats'],
            'totalVentes' => $totals['totalVentes'],
            'estimationFormSubmissionsThisMonth' => $estimationFormSubmissionsThisMonth,
        ]);
    }    

    private function getTotalFormResponses(): array
{
    // Récupérer le nombre total de formResponseId différents
    $totalFormResponses = $this->formResponseRepository->countDistinctFormResponseIds();

    // Récupérer le nombre total de mandats
    $totalMandats = $this->formResponseRepository->countMandats();

    // Récupérer le nombre total de ventes
    $totalVentes = $this->formResponseRepository->countVentes();

    return [
        'totalFormResponses' => $totalFormResponses,
        'totalMandats' => $totalMandats,
        'totalVentes' => $totalVentes,
    ];
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
        
        MenuItem::linkToCrud('Soumissions de formulaires', 'fas fa-file-alt', FormResponse::class);
    }
}
