<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/todo', name: 'app_todo')]
    public function index(Request $req): Response
    {
        // Afficher le tableau de todo
        $session = $req->getSession();
        if (!$session->has('todos')) {
            $todos = array(
                'achat' => 'acheter une clé usb',
                'cours' => 'finaliser mon cours',
                'correction' => 'corriger mes examens',
            );
            $session->set('todos', $todos);
        } else {
            $todos = $session->get('todos');
        }
        $this->addFlash('info', "La liste des todos viens d'etre initialisée");
        return $this->render('todo/index.html.twig', [
            'controller_name' => 'TodoController',
            'todos' => $todos
        ]);
    }

    #[Route('/todo/{name}/{content}', name: 'app_todo.add')]
    public function addTodo(Request $req, string $name, string $content)
    {
        $session = $req->getSession();
        if ($session->has('todos')) {
            $todos = $session->get('todos');
            if (isset($todos[$name])) {
                $this->addFlash('error', "La todo d'id $name existe déjà");
            } else {
                $todos[$name] = $content;
                $session->set('todos', $todos);
                $this->addFlash('success', "La todo d'id $name a été ajouté");
            }
        } else {
            $this->addFlash('error', "La liste des todos n'a pas été trouvée");
        }
        return $this->redirectToRoute('app_todo');
    }
}
