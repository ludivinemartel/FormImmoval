<?php

namespace App\Entity;

use App\Repository\FormDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormDataRepository::class)]
class FormData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $forname = null;

    #[ORM\Column]
    private ?int $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 2000)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    private ?string $quartier = null;

    #[ORM\Column]
    private ?int $surface = null;

    #[ORM\Column]
    private ?int $sejour = null;

    #[ORM\Column]
    private ?int $pieces = null;

    #[ORM\Column]
    private ?int $chambres = null;

    #[ORM\Column(nullable: true)]
    private ?int $bain = null;

    #[ORM\Column(nullable: true)]
    private ?int $eau = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $etat = null;

    #[ORM\Column(length: 255)]
    private ?string $locataire = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $immeuble = null;

    #[ORM\Column(nullable: true)]
    private ?int $years = null;

    #[ORM\Column(nullable: true)]
    private ?int $stagehome = null;

    #[ORM\Column(nullable: true)]
    private ?int $stage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $chauffage = null;

    #[ORM\Column(nullable: true)]
    private ?int $balcon = null;

    #[ORM\Column(nullable: true)]
    private ?int $terrasse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cave = null;

    #[ORM\Column(nullable: true)]
    private ?int $parking = null;

    #[ORM\Column(nullable: true)]
    private ?int $garage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $view = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $exposition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getForname(): ?string
    {
        return $this->forname;
    }

    public function setForname(string $forname): static
    {
        $this->forname = $forname;

        return $this;
    }

    public function getPhone(): ?int
    {
        return $this->phone;
    }

    public function setPhone(int $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getQuartier(): ?string
    {
        return $this->quartier;
    }

    public function setQuartier(string $quartier): static
    {
        $this->quartier = $quartier;

        return $this;
    }

    public function getSurface(): ?int
    {
        return $this->surface;
    }

    public function setSurface(int $surface): static
    {
        $this->surface = $surface;

        return $this;
    }

    public function getSejour(): ?int
    {
        return $this->sejour;
    }

    public function setSejour(int $sejour): static
    {
        $this->sejour = $sejour;

        return $this;
    }

    public function getPieces(): ?int
    {
        return $this->pieces;
    }

    public function setPieces(int $pieces): static
    {
        $this->pieces = $pieces;

        return $this;
    }

    public function getChambres(): ?int
    {
        return $this->chambres;
    }

    public function setChambres(int $chambres): static
    {
        $this->chambres = $chambres;

        return $this;
    }

    public function getBain(): ?int
    {
        return $this->bain;
    }

    public function setBain(?int $bain): static
    {
        $this->bain = $bain;

        return $this;
    }

    public function getEau(): ?int
    {
        return $this->eau;
    }

    public function setEau(?int $eau): static
    {
        $this->eau = $eau;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLocataire(): ?string
    {
        return $this->locataire;
    }

    public function setLocataire(string $locataire): static
    {
        $this->locataire = $locataire;

        return $this;
    }

    public function getImmeuble(): ?string
    {
        return $this->immeuble;
    }

    public function setImmeuble(?string $immeuble): static
    {
        $this->immeuble = $immeuble;

        return $this;
    }

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function setYears(?int $years): static
    {
        $this->years = $years;

        return $this;
    }

    public function getStagehome(): ?int
    {
        return $this->stagehome;
    }

    public function setStagehome(?int $stagehome): static
    {
        $this->stagehome = $stagehome;

        return $this;
    }

    public function getStage(): ?int
    {
        return $this->stage;
    }

    public function setStage(?int $stage): static
    {
        $this->stage = $stage;

        return $this;
    }

    public function getChauffage(): ?string
    {
        return $this->chauffage;
    }

    public function setChauffage(?string $chauffage): static
    {
        $this->chauffage = $chauffage;

        return $this;
    }

    public function getBalcon(): ?int
    {
        return $this->balcon;
    }

    public function setBalcon(?int $balcon): static
    {
        $this->balcon = $balcon;

        return $this;
    }

    public function getTerrasse(): ?int
    {
        return $this->terrasse;
    }

    public function setTerrasse(?int $terrasse): static
    {
        $this->terrasse = $terrasse;

        return $this;
    }

    public function getCave(): ?string
    {
        return $this->cave;
    }

    public function setCave(?string $cave): static
    {
        $this->cave = $cave;

        return $this;
    }

    public function getParking(): ?int
    {
        return $this->parking;
    }

    public function setParking(?int $parking): static
    {
        $this->parking = $parking;

        return $this;
    }

    public function getGarage(): ?int
    {
        return $this->garage;
    }

    public function setGarage(?int $garage): static
    {
        $this->garage = $garage;

        return $this;
    }

    public function getView(): ?string
    {
        return $this->view;
    }

    public function setView(?string $view): static
    {
        $this->view = $view;

        return $this;
    }

    public function getExposition(): ?string
    {
        return $this->exposition;
    }

    public function setExposition(?string $exposition): static
    {
        $this->exposition = $exposition;

        return $this;
    }
}
