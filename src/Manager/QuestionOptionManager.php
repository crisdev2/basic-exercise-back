<?php
namespace App\Manager;

use App\Entity\Question;
use App\Entity\QuestionOption;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class QuestionOptionManager 
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
        ->getRepository(QuestionOption::class)
        ->find($id);
    } else {
      $record = new QuestionOption();
    }
    $record->setIdQuestion($this->doctrine->getRepository(Question::class)->find($data['idQuestion']));
    $record->setLabel($data['label']);

    $this->entityManager->persist($record);
    $this->entityManager->flush();

    return $record;
  }
}