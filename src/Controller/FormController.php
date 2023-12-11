<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/formulaire')]
class FormController extends AbstractController
{
    #[Route('/', name: 'app_formulaire_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('formulaire/index.html.twig');
    }
}