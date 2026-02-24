<?php

namespace App\Controller\Api;

use App\Repository\TodoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
class TodoController extends AbstractController
{
    #[Route('/todos', name: 'api_todos', methods: ['GET'])]
    public function list(TodoRepository $todoRepository): JsonResponse
    {
        $todos = $todoRepository->findAllOrdered();
        $data = array_map(fn ($t) => [
            'id' => $t->getId(),
            'titre' => $t->getTitre(),
            'done' => $t->isDone(),
        ], $todos);

        return $this->json($data);
    }
}
