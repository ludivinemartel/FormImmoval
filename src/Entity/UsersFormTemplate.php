<?php

namespace App\Entity;

use App\Repository\UsersFormTemplateRepository;
use Doctrine\ORM\Mapping as ORM;
use Endroid\QrCode\QrCode;

#[ORM\Entity(repositoryClass: UsersFormTemplateRepository::class)]
class UsersFormTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $QRCode = null;

    #[ORM\OneToOne(inversedBy: 'usersFormTemplate', cascade: ['persist', 'remove'])]
    private ?User $Users = null;

    #[ORM\ManyToOne]
    private ?FormTemplate $FormTemplate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQRCode(): ?string
    {
        return $this->QRCode;
    }

    public function setQRCode(?string $QRCode): static
    {
        if ($QRCode !== null) {
            $qrCodeObject = QrCode::create($QRCode);
    
            // Créer un fichier temporaire pour stocker le QR code
            $tempFilePath = tempnam(sys_get_temp_dir(), 'qrcode');
            $file = fopen($tempFilePath, 'wb');
            fwrite($file, $qrCodeObject->getData());
            fclose($file);
    
            // Lire le contenu du fichier
            $qrCodeContent = file_get_contents($tempFilePath);
    
            // Supprimer le fichier temporaire
            unlink($tempFilePath);
    
            $this->QRCode = base64_encode($qrCodeContent); // Stocker le contenu du QR code en base64
        } else {
            $this->QRCode = null;
        }
    
        return $this;
    }    

    public function getUsers(): ?User
    {
        return $this->Users;
    }

    public function setUsers(?User $Users): static
    {
        $this->Users = $Users;

        return $this;
    }

    public function getFormTemplate(): ?FormTemplate
    {
        return $this->FormTemplate;
    }

    public function setFormTemplate(?FormTemplate $FormTemplate): static
    {
        $this->FormTemplate = $FormTemplate;

        return $this;
    }
}
