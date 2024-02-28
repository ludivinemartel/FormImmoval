<?php

namespace App\Entity;

use App\Repository\FormQuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormQuestionRepository::class)]
class FormQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10000)]
    private ?string $questionText = null;

    #[ORM\ManyToOne(inversedBy: 'formQuestions')]
    private ?FormTemplate $formTemplate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $QuestionType = null;

    #[ORM\Column(nullable: true)]
    private ?bool $checkboxField = null;

    #[ORM\Column(nullable: true)]
    private ?array $checkboxText = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestionText(): ?string
    {
        return $this->questionText;
    }

    public function setQuestionText(string $questionText): static
    {
        $this->questionText = $questionText;

        return $this;
    }

    public function getFormTemplate(): ?FormTemplate
    {
        return $this->formTemplate;
    }

    public function setFormTemplate(?FormTemplate $FormTemplate): static
    {
        $this->formTemplate = $FormTemplate;

        return $this;
    }

    public function getQuestionType(): ?string
    {
        return $this->QuestionType;
    }

    public function setQuestionType(?string $QuestionType): static
    {
        $this->QuestionType = $QuestionType;

        return $this;
    }

    public function isCheckboxField(): ?bool
    {
        return $this->checkboxField;
    }

    public function setCheckboxField(?bool $checkboxField): static
    {
        $this->checkboxField = $checkboxField;

        return $this;
    }

    public function getCheckboxText(): ?array
    {
        return $this->checkboxText;
    }

    public function setCheckboxText(?array $checkboxText): static
    {
        $this->checkboxText = $checkboxText;

        return $this;
    }

}
