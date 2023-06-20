<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(Request $req): Response
    {
        $session = $req->getSession();
        if ($session->has('nbVisite')) {
            $nbre_visite = (int)$session->get('nbVisite') + 1;
        } else {
            $nbre_visite = 1;
        }
        $session->set('nbVisite', $nbre_visite);

        return $this->render('session/index.html.twig', [
            'nbre_visite' => $nbre_visite,
        ]);
    }
}
