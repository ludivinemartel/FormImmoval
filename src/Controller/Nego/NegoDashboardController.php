<?php

namespace App\Controller\Nego;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;

class NegoDashboardController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nego', name: 'nego')]
    public function index(): Response
    {
        $FormTemplates = $this->entityManager->getRepository(\App\Entity\FormTemplate::class)->findAll();

        return $this->render('nego_dashboard/index.html.twig', [
            'FormTemplates' => $FormTemplates,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('FormTemplate', 'fas fa-list', \App\Entity\FormTemplate::class);
    }
}
