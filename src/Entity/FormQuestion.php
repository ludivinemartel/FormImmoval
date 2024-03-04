<?php

namespace App\Entity;

use App\Repository\FormQuestionRepository;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $selectOptions = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $questionType = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private ?array $options = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isRequired = null;

    
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

    public function __toString()
    {
        return $this->getQuestionText();
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

    public function getSelectOptions(): ?array
    {
        return $this->selectOptions;
    }

    public function setSelectOptions(?array $selectOptions): static
    {
        $this->selectOptions = $selectOptions;

        return $this;
    }

    public function getQuestionType(): ?string
    {
        return $this->questionType;
    }

    public function setQuestionType(?string $questionType): static
    {
        $this->questionType = $questionType;

        return $this;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function setOptions(?array $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function isIsRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(?bool $isRequired): static
    {
        $this->isRequired = $isRequired;

        return $this;
    }

}
