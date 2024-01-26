<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\FormTemplate;
use App\Entity\FormReponse;
use TCPDF;

class PdfController extends AbstractController
{

    private EntityManagerInterface $entityManager;
 

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/user/download-responses/{formTemplateId}/{date}', name: 'app_user_download_responses', methods: ['GET'])]
    public function downloadResponses(int $formTemplateId, string $date): BinaryFileResponse
{
   // Récupérer le modèle de formulaire depuis la base de données
   $formTemplate = $this->entityManager->getRepository(FormTemplate::class)->find($formTemplateId);

   // Récupérer les réponses pour le formulaire spécifié et la date spécifiée
   $formResponses = $this->entityManager->getRepository(FormReponse::class)->findBy([
       'FormTemplateTitle' => $formTemplate,
       'Date' => new \DateTimeImmutable($date),
   ]);

    // Créer une instance de TCPDF
    $pdf = new TCPDF();
    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
    $pdf->AddPage();

    // Ajouter le titre
    $pdf->Cell(0, 10, 'Réponses au formulaire ' . $formTemplate->getTitle(), 0, 1, 'C');
    $pdf->Ln(10);

    // Ajouter les réponses au PDF
    foreach ($formResponses as $formResponse) {
        if ($formResponse->getFormQuestion()) {
            $pdf->MultiCell(0, 10, $formResponse->getFormQuestion()->getQuestionText() . ': ' . $formResponse->getFormTextAnswer(), 0, 'L');
            $pdf->Ln(5);
        }
    }

    // Définir le chemin de sauvegarde du fichier PDF
    $filePath = $this->getParameter('kernel.project_dir') . '/var/pdf/responses_' . $formTemplate->getId() . '.pdf';

    // Sauvegarder le fichier PDF
    $pdf->Output($filePath, 'F');

    // Créer une réponse BinaryFileResponse pour le téléchargement automatique
    $response = new BinaryFileResponse($filePath);
    $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT, 'responses.pdf');

    return $response;
}
}

