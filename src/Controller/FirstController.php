<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        return $this->render('first/index.html.twig', [
            'name' => "JoCode",
            'firstName' => 'Dev'
        ]);
    }

    #[Route('/sayhello/{name}', name: 'say.hello')]
    public function sayHello($name, Request $res): Response
    {
        return $this->render('first/hello.html.twig', [
            'name' => $name
        ]);
    }

    #[Route('/template', name: 'template')]
    public function indtemplateex(): Response
    {
        return $this->render('template.html.twig');
    }
}
