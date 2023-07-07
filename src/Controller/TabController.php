<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{nb<\d+>?5}', name: 'app_tab')]
    public function index($nb): Response
    {
        $notes = [];
        for ($i = 0; $i < $nb; $i++) {
            $notes[] = rand(0, 20);
        }
        return $this->render('tab/index.html.twig', [
            'controller_name' => 'TabController',
            'notes' => $notes
        ]);
    }

    #[Route('/tab/users', name: 'app_tab.users')]
    public function users(): Response
    {
        $users = [
            [
                'firstname' => 'John',
                'name' => "Doe",
                'age' => 20
            ],
            [
                'firstname' => 'Skander',
                'name' => "Doe",
                'age' => 03
            ],
            [
                'firstname' => 'Joel',
                'name' => "Code",
                'age' => 24
            ]
        ];
        return $this->render('tab/users.html.twig', [
            'users' => $users
        ]);
    }
}
