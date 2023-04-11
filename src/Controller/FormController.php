<?php

namespace App\Controller;

use App\Entity\Form;
use App\Manager\FormManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/api/form', name: 'api_form_index', methods: ['GET'])]
    public function index(
        ManagerRegistry $doctrine,
    ): JsonResponse
    {
        $records = $doctrine
            ->getRepository(Form::class)
            ->findAll();

        return $this->json([
            'message' => 'Records returned!',
            'records' => $records,
        ]);
    }

    #[Route('/api/form/{id}', name: 'api_form_show', methods: ['GET'])]
    public function show(
        int $id,
        ManagerRegistry $doctrine,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(Form::class)
            ->find($id);

        return $this->json([
            'message' => 'Record returned!',
            'record' => $record,
        ]);
    }
    
    #[Route('/api/form', name: 'api_form_new', methods: ['POST'])]
    public function new(
        Request $request,
        FormManager $manager,
    ): JsonResponse
    {
        $data = $request->request->all();

        $record = $manager->save($data);

        return $this->json([
            'message' => 'Record created!',
            'record' => $record,
        ]);
    }

    #[Route('/api/form/{id}', name: 'api_form_edit', methods: ['PUT'])]
    public function edit(
        int $id,
        ManagerRegistry $doctrine,
        Request $request,
        FormManager $manager,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(Form::class)
            ->find($id);
        if (!$record) {
            return $this->json([
                'message' => 'No record found!',
                'record' => null,
            ], 400);
        }

        $data = $request->request->all();

        $record = $manager->save($data, $id);

        return $this->json([
            'message' => 'Record updated!',
            'record' => $record,
        ]);
    }

    #[Route('/api/form/{id}', name: 'api_form_delete', methods: ['DELETE'])]
    public function delete(
        int $id,
        ManagerRegistry $doctrine,
        EntityManagerInterface $entityManager,
        Request $request,
        FormManager $manager,
    ): JsonResponse
    {
        $record = $doctrine
            ->getRepository(Form::class)
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
