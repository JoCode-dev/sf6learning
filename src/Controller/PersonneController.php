<?php

namespace App\Controller;

use App\Entity\Personne;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('personne')]
class PersonneController extends AbstractController
{
    #[Route('/', name: 'personne.list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Personne::class);
        $personnes = $repo->findAll();

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes
        ]);
    }

    #[Route('/all/{page?1}/{limit?12}', name: 'personne.list.all')]
    public function indexAll(EntityManagerInterface $entityManager, int $page, int $limit): Response
    {
        $repo = $entityManager->getRepository(Personne::class);
        $dataCount = $repo->count([]);
        $nbrePage = ceil($dataCount / $limit);
        $personnes = $repo->findBy([], ['name' => 'ASC'], $limit, ($page - 1) * $limit);

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
            'isPaginated' => true,
            'nbrePage' => $nbrePage,
            'page' => $page,
            'limit' => $limit
        ]);
    }

    #[Route('/{id<\d+>}', name: 'personne.detail')]
    public function detail(EntityManagerInterface $entityManager, int $id): Response
    {
        $repo = $entityManager->getRepository(Personne::class);
        $personne = $repo->find($id);

        if (!$personne) {
            $this->addFlash('error', "La personne d'id $id n'existe pas");
            return $this->redirectToRoute('personne.list');
        }

        return $this->render('personne/detail.html.twig', [
            'personne' => $personne
        ]);
    }

    #[Route('/add', name: 'personne.add')]
    public function addPersonne(EntityManagerInterface $entityManager): Response
    {
        // Add personne
        $personne = new Personne();
        $personne->setFirstname('Joel');
        $personne->setName('Code');
        $personne->setAge(23);

        // Prepare Transaction
        $entityManager->persist($personne);

        // Execute Query 
        $entityManager->flush();


        return $this->render('personne/detail.html.twig', [
            'personne' => $personne
        ]);
    }

    #[Route('/delete/{id}', name: "personne.delete")]
    public function deletePersonne(Personne $personne = null, ManagerRegistry $doctrine): RedirectResponse
    {
        // Récupérer la personne
        if ($personne) {
            $manager = $doctrine->getManager();
            $manager->remove($personne);
            $manager->flush();
            $this->addFlash("success", "Personne supprimée");
        } else {
            $this->addFlash("error", "Personne inexistante");
        }
        return $this->redirectToRoute('personne.list.all');
    }

    #[Route('/update/{id}/{name}/{firstname}/{age}', name: 'personne.update')]
    public function updatePersonne(
        Personne $personne = null,
        string $name,
        string $firstname,
        string $age,
        EntityManager $entityManager
    ): Response {
        if ($personne) {
            $personne->setName($name);
            $personne->setFirstname($firstname);
            $personne->setAge($age);

            $entityManager->persist($personne);
            $entityManager->flush();
            $this->addFlash("success", "Personne updated");
        } else {
            $this->addFlash("error", "Personne inexistante");
        }
        return $this->redirectToRoute('personne.list.all');
    }

    #[Route('/all/age/{ageMin}/{ageMax}', name: 'personne.list.age')]
    public function personneByAge(EntityManagerInterface $entityManager, $ageMin, $ageMax): Response
    {
        $repo = $entityManager->getRepository(Personne::class);
        $personnes = $repo->findPersonneByAgeInterval($ageMin, $ageMax);

        return $this->render('personne/index.html.twig', [
            'personnes' => $personnes,
        ]);
    }
}
