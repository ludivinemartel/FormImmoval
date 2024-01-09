<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\LoginType;

class SecurityController extends AbstractController {

    #[Route(path: '/connexion', name: 'app_login_index')]
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $form = $this->createForm(LoginType::class);

        $error = $authenticationUtils->getLastAuthenticationError();
    
        return $this->render('login/index.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}
