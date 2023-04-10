<?php

namespace App\Entity;

use App\Repository\QuestionOptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionOptionRepository::class)]
class QuestionOption
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\ManyToOne(inversedBy: 'idQuestionOptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Question $idQuestion = null;

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

    public function getIdQuestion(): ?Question
    {
        return $this->idQuestion;
    }

    public function setIdQuestion(?Question $idQuestion): self
    {
        $this->idQuestion = $idQuestion;

        return $this;
    }
}
