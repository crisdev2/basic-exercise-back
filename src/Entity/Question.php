<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuestionType $idQuestionType = null;

    #[ORM\Column]
    private ?bool $required = null;

    #[ORM\OneToMany(mappedBy: 'idQuestion', targetEntity: QuestionOption::class, orphanRemoval: true)]
    private Collection $idQuestionOptions;

    #[Ignore()]
    #[ORM\ManyToOne(inversedBy: 'idQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Form $idForm = null;

    public function __construct()
    {
        $this->idQuestionOptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getIdQuestionType(): ?QuestionType
    {
        return $this->idQuestionType;
    }

    public function setIdQuestionType(?QuestionType $idQuestionType): self
    {
        $this->idQuestionType = $idQuestionType;

        return $this;
    }

    public function isRequired(): ?bool
    {
        return $this->required;
    }

    public function setRequired(bool $required): self
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return Collection<int, QuestionOption>
     */
    public function getIdQuestionOptions(): Collection
    {
        return $this->idQuestionOptions;
    }

    public function addIdQuestionOption(QuestionOption $idQuestionOption): self
    {
        if (!$this->idQuestionOptions->contains($idQuestionOption)) {
            $this->idQuestionOptions->add($idQuestionOption);
            $idQuestionOption->setIdQuestion($this);
        }

        return $this;
    }

    public function removeIdQuestionOption(QuestionOption $idQuestionOption): self
    {
        if ($this->idQuestionOptions->removeElement($idQuestionOption)) {
            // set the owning side to null (unless already changed)
            if ($idQuestionOption->getIdQuestion() === $this) {
                $idQuestionOption->setIdQuestion(null);
            }
        }

        return $this;
    }

    public function getIdForm(): ?Form
    {
        return $this->idForm;
    }

    public function setIdForm(?Form $idForm): self
    {
        $this->idForm = $idForm;

        return $this;
    }
}
