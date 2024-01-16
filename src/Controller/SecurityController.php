<?php

namespace App\Controller;

use App\Form\RegistrationType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SecurityController extends AbstractController
{
    #[Route('/connexion', name: 'security.login', methods: ['GET', 'POST'])]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, TokenStorageInterface $tokenStorage): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
    
        // Check if the login form is submitted
    if ($this->isCsrfTokenValid('authenticate', $request->request->get('_csrf_token'))) {
        // Check if the user has the ROLE_USER role
        if ($this->getUser() instanceof User) {
            $roles = $this->getUser()->getRoles();
            
            // Redirect based on the user's role
            if (in_array('ROLE_USER', $roles)) {
                return $this->redirectToRoute('user_dashboard');
            } elseif (in_array('ROLE_ADMIN', $roles)) {
                return $this->redirectToRoute('app_home');
            }
        }
    }
        
        $Forname = '';
        $Name = '';
    
        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'Forname'       => $Forname,
            'Name'          => $Name,
        ]);
    }
    
    #[Route('/deconnexion', 'security.logout')]
    public function logout()
    {
        //Géré dans le security.yaml
    }

    #[Route ('/inscription', name: 'security.registration', methods: ['GET', 'POST'])]
    public function registration(Request $request, EntityManagerInterface $manager) : Response
    {
        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $form = $this->createForm(RegistrationType::class, $user,);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $this->addFlash(
                'success',
                'Votre compte a bien été créé.'
            );

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('security.login');

        }
        return $this->render('security/registration.html.twig',[
            'form'=> $form->createView()
        ]);
    }
}
