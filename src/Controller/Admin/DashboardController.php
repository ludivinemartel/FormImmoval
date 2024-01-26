<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\FormTemplate;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', []);
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
