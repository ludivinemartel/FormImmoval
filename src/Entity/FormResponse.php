<?php

namespace App\Entity;

use App\Repository\FormResponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormResponseRepository::class)]
class FormResponse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $FormTextAnswer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormTemplate $FormTemplateTitle = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?FormQuestion $FormQuestion = null;

    #[ORM\ManyToOne(inversedBy: 'FormResponse')]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $Date = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $mandatDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $venteDate = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $formResponseId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $responseDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $relanceDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormTextAnswer(): ?string
    {
        return $this->FormTextAnswer;
    }

    public function setFormTextAnswer(string $FormTextAnswer): static
    {
        $this->FormTextAnswer = $FormTextAnswer;

        return $this;
    }

    public function getFormTemplateTitle(): ?FormTemplate
    {
        return $this->FormTemplateTitle;
    }

    public function setFormTemplateTitle(?FormTemplate $FormTemplateTitle): static
    {
        $this->FormTemplateTitle = $FormTemplateTitle;

        return $this;
    }

    public function getFormQuestion(): ?FormQuestion
    {
        return $this->FormQuestion;
    }

    public function setFormQuestion(?FormQuestion $FormQuestion): static
    {
        $this->FormQuestion = $FormQuestion;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->Date;
    }

    public function setDate(\DateTimeImmutable $Date): static
    {
        $this->Date = $Date;

        return $this;
    }

    public function getMandatDate(): ?\DateTime
    {
        return $this->mandatDate;
    }

    public function setMandatDate(?\DateTime $mandatDate): static
    {
        $this->mandatDate = $mandatDate;

        return $this;
    }

    public function getVenteDate(): ?\DateTime
    {
        return $this->venteDate;
    }

    public function setVenteDate(?\DateTime $venteDate): static
    {
        $this->venteDate = $venteDate;

        return $this;
    }

    public function getFormResponseId(): ?string
    {
        return $this->formResponseId;
    }

    public function setFormResponseId(?string $formResponseId): static
    {
        $this->formResponseId = $formResponseId;

        return $this;
    }

    public function getResponseDate(): ?\DateTimeInterface
    {
        return $this->responseDate;
    }

    public function setResponseDate(?\DateTimeInterface $responseDate): static
    {
        $this->responseDate = $responseDate;

        return $this;
    }

    public function getRelanceDate(): ?\DateTimeInterface
    {
        return $this->relanceDate;
    }

    public function setRelanceDate(?\DateTimeInterface $relanceDate): static
    {
        $this->relanceDate = $relanceDate;

        return $this;
    }
}
