<?php

namespace App\Controller;

use App\Entity\Question;
use App\Manager\QuestionManager;
use App\Service\RequestService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/api/question', name: 'api_question_index', methods: ['GET'])]
    public function index(
        ManagerRegistry $doctrine,
    ): JsonResponse
    {
        $records = $doctrine
            ->getRepository(Question::class)
            ->findAll();

        return $this->json([
            'message' => 'Records returned!',
            'records' => $records,
        ]);
    }

    #[Route('/api/question/{id}', name: 'api_question_show', methods: ['GET'])]
    public function show(
        int $id,
        ManagerRegistry $doctrine,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(Question::class)
            ->find($id);

        if (!$record) {
            return $this->json([
                'message' => 'No record found!',
                'record' => null,
            ], 400);
        }

        return $this->json([
            'message' => 'Record returned!',
            'record' => $record,
        ]);
    }
    
    #[Route('/api/question', name: 'api_question_new', methods: ['POST'])]
    public function new(
        RequestService $requestService,
        QuestionManager $manager,
    ): JsonResponse
    {
        $data = $requestService->getContent();

        $record = $manager->save($data);

        return $this->json([
            'message' => 'Record created!',
            'record' => $record,
        ]);
    }

    #[Route('/api/question/{id}', name: 'api_question_edit', methods: ['PUT'])]
    public function edit(
        int $id,
        ManagerRegistry $doctrine,
        RequestService $requestService,
        QuestionManager $manager,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(Question::class)
            ->find($id);
        if (!$record) {
            return $this->json([
                'message' => 'No record found!',
                'record' => null,
            ], 400);
        }

        $data = $requestService->getContent();

        $record = $manager->save($data, $id);

        return $this->json([
            'message' => 'Record updated!',
            'record' => $record,
        ]);
    }

    #[Route('/api/question/{id}', name: 'api_question_delete', methods: ['DELETE'])]
    public function delete(
        int $id,
        ManagerRegistry $doctrine,
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(Question::class)
            ->find($id);
        if (!$record) {
            return $this->json([
                'message' => 'No record found!',
                'record' => null,
            ], 400);
        }

        $entityManager->remove($record);
        $entityManager->flush();

        return $this->json([
            'message' => 'Record deleted!',
            'record' => $record,
        ]);
    }
}
