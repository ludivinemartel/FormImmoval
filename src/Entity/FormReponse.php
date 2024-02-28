<?php

namespace App\Entity;

use App\Repository\FormReponseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormReponseRepository::class)]
class FormReponse
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

}
