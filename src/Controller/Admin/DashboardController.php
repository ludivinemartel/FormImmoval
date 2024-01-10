<?php

namespace App\Controller\Admin;

use App\Entity\Negociateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Controller\Admin\FormTemplateCrudController;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
    $url = $this ->adminUrlGenerator
    ->setController(FormTemplateCrudController::class)
    ->generateUrl();

    return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Dashboard Service Communication');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Negociateurs');
        yield MenuItem::subMenu('Actions', 'fas fa-bars')->setSubItems([
                MenuItem::linkToCrud('Ajouter un négociateur', 'fas fa-plus', Negociateur::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud('Voir négociateurs', 'fas fa-eye', Negociateur::class)
            ]);
    }
}
