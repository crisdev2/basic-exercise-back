<?php

namespace App\Controller;

use App\Entity\QuestionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class QuestionTypeController extends AbstractController
{
    #[Route('/api/question_type', name: 'api_question_type_index', methods: ['GET'])]
    public function index(
        ManagerRegistry $doctrine,
    ): JsonResponse
    {
        $records = $doctrine
            ->getRepository(QuestionType::class)
            ->findAll();

        return $this->json([
            'message' => 'Records returned!',
            'records' => $records,
        ]);
    }
}
