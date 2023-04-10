<?php

namespace App\Entity;

use App\Repository\FormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormRepository::class)]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $end = null;

    #[ORM\OneToMany(mappedBy: 'idForm', targetEntity: Question::class, orphanRemoval: true)]
    private Collection $idQuestions;

    public function __construct()
    {
        $this->idQuestions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(?\DateTimeInterface $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(?\DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getIdQuestions(): Collection
    {
        return $this->idQuestions;
    }

    public function addIdQuestion(Question $idQuestion): self
    {
        if (!$this->idQuestions->contains($idQuestion)) {
            $this->idQuestions->add($idQuestion);
            $idQuestion->setIdForm($this);
        }

        return $this;
    }

    public function removeIdQuestion(Question $idQuestion): self
    {
        if ($this->idQuestions->removeElement($idQuestion)) {
            // set the owning side to null (unless already changed)
            if ($idQuestion->getIdForm() === $this) {
                $idQuestion->setIdForm(null);
            }
        }

        return $this;
    }
}
