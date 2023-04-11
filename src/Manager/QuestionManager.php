<?php
namespace App\Manager;

use App\Entity\Form;
use App\Entity\Question;
use App\Entity\QuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class QuestionManager 
{
  private $doctrine;
  private $entityManager;

  public function __construct(
    ManagerRegistry $doctrine,
    EntityManagerInterface $entityManager,
  )
  {
    $this->doctrine = $doctrine;
    $this->entityManager = $entityManager;
  }

  public function save($data, $id = null)
  {
    if ($id) {
      $record = $this->doctrine
        ->getRepository(Question::class)
        ->find($id);
    } else {
      $record = new Question();
    }
    $record->setIdQuestionType($this->doctrine->getRepository(QuestionType::class)->find($data['idQuestionType']));
    $record->setLabel($data['label']);
    $record->setRequired($data['required']);
    $record->setIdForm($this->doctrine->getRepository(Form::class)->find($data['idForm']));

    $this->entityManager->persist($record);
    $this->entityManager->flush();

    return $record;
  }
}