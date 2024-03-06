<?php

namespace App\Entity;

use App\Repository\FormTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormTemplateRepository::class)]
class FormTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\OneToMany(mappedBy: 'formTemplate', targetEntity: FormQuestion::class, cascade: ['persist', 'remove'])]
    private Collection $formQuestions;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $thankYouMessage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $introMessage = null;

    public function __construct()
    {
        $this->formQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection<int, FormQuestion>
     */
    public function getFormQuestions(): Collection
    {
        return $this->formQuestions;
    }

    public function addFormQuestion(FormQuestion $formQuestion): static
    {
        if (!$this->formQuestions->contains($formQuestion)) {
            $this->formQuestions->add($formQuestion);
            $formQuestion->setFormTemplate($this);
        }

        return $this;
    }

    public function removeFormQuestion(FormQuestion $formQuestion): static
    {
        if ($this->formQuestions->removeElement($formQuestion)) {
            // set the owning side to null (unless already changed)
            if ($formQuestion->getFormTemplate() === $this) {
                $formQuestion->setFormTemplate(null);
            }
        }

        return $this;
    }

    public function getThankYouMessage(): ?string
    {
        return $this->thankYouMessage;
    }

    public function setThankYouMessage(?string $thankYouMessage): static
    {
        $this->thankYouMessage = $thankYouMessage;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIntroMessage(): ?string
    {
        return $this->introMessage;
    }

    public function setIntroMessage(?string $introMessage): static
    {
        $this->introMessage = $introMessage;

        return $this;
    }
}
