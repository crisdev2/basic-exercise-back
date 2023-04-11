<?php
namespace App\Manager;

use App\Entity\Form;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class FormManager 
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
        ->getRepository(Form::class)
        ->find($id);
    } else {
      $record = new Form();
    }
    $record->setTitle($data['title']);
    $record->setDescription($data['description']);
    $record->setStart(new \DateTime($data['start']));
    $record->setEnd(new \DateTime($data['end']));

    $this->entityManager->persist($record);
    $this->entityManager->flush();

    return $record;
  }
}