<?php

namespace App\Controller;

use App\Entity\FormData;
use App\Form\EstimationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/formulaire')]
class FormController extends AbstractController
{
    #[Route('/', name: 'app_formulaire_index', methods: ['GET'])]
    public function index(): Response
    {
        $formData = new FormData();
        $form = $this->createForm(EstimationFormType::class, $formData);

        return $this->render('formulaire/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/submit', name: 'app_formulaire_submit', methods: ['POST'])]
    public function submit(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formData = new FormData();
        $form = $this->createForm(EstimationFormType::class, $formData);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $entityManager->persist($formData);
            $entityManager->flush();

            return $this->redirectToRoute('app_formulaire_index');
        }
    
        return $this->render('formulaire/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
