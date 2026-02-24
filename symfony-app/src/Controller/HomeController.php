<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home', methods: ['GET'])]
    public function index(): Response
    {
        $html = <<<'HTML'
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo list</title>
    <style>
        body { font-family: sans-serif; max-width: 600px; margin: 2rem auto; padding: 0 1rem; }
        h1 { color: #333; }
        ul { list-style: none; padding: 0; }
        li { padding: 0.5rem 0; border-bottom: 1px solid #eee; display: flex; align-items: center; gap: 0.5rem; }
        li.done { color: #999; text-decoration: line-through; }
        .id { font-weight: bold; color: #666; min-width: 2rem; }
        .loading { color: #666; }
        .error { color: #c00; }
    </style>
</head>
<body>
    <h1>Todo list</h1>
    <p id="status" class="loading">Chargement…</p>
    <ul id="list"></ul>
    <script>
        const status = document.getElementById('status');
        const list = document.getElementById('list');
        fetch('/api/todos')
            .then(r => r.ok ? r.json() : Promise.reject(new Error(r.statusText)))
            .then(todos => {
                status.textContent = '';
                todos.forEach(t => {
                    const li = document.createElement('li');
                    if (t.done) li.classList.add('done');
                    li.innerHTML = '<span class="id">' + t.id + '</span> <span>' + document.createTextNode(t.titre).textContent + '</span> ' + (t.done ? '✓' : '');
                    list.appendChild(li);
                });
            })
            .catch(e => {
                status.textContent = 'Erreur: ' + e.message;
                status.classList.add('error');
            });
    </script>
</body>
</html>
HTML;

        return new Response($html);
    }
}
