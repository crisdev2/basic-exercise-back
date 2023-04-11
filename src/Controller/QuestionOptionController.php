<?php

namespace App\Controller;

use App\Entity\QuestionOption;
use App\Manager\QuestionOptionManager;
use App\Service\RequestService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class QuestionOptionController extends AbstractController
{
    #[Route('/api/question_option', name: 'api_question_option_index', methods: ['GET'])]
    public function index(
        ManagerRegistry $doctrine,
    ): JsonResponse
    {
        $records = $doctrine
            ->getRepository(QuestionOption::class)
            ->findAll();

        return $this->json([
            'message' => 'Records returned!',
            'records' => $records,
        ]);
    }

    #[Route('/api/question_option/{id}', name: 'api_question_option_show', methods: ['GET'])]
    public function show(
        int $id,
        ManagerRegistry $doctrine,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(QuestionOption::class)
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
    
    #[Route('/api/question_option', name: 'api_question_option_new', methods: ['POST'])]
    public function new(
        RequestService $requestService,
        QuestionOptionManager $manager,
    ): JsonResponse
    {
        $data = $requestService->getContent();

        $record = $manager->save($data);

        return $this->json([
            'message' => 'Record created!',
            'record' => $record,
        ]);
    }

    #[Route('/api/question_option/{id}', name: 'api_question_option_edit', methods: ['PUT'])]
    public function edit(
        int $id,
        ManagerRegistry $doctrine,
        RequestService $requestService,
        QuestionOptionManager $manager,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(QuestionOption::class)
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

    #[Route('/api/question_option/{id}', name: 'api_question_option_delete', methods: ['DELETE'])]
    public function delete(
        int $id,
        ManagerRegistry $doctrine,
        EntityManagerInterface $entityManager,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(QuestionOption::class)
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
