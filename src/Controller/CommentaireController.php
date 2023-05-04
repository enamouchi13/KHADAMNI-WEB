<?php

namespace App\Controller;

use App\Entity\Commentaire;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentaireController extends AbstractController
{
    #[Route('/commentaire', name: 'app_commentaire')]
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }


    #[Route('/affichercommentaire', name: 'app_affichercommentaire')]
    public function affichercommentaire(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Commentaire::class);
        $commentaire=$repository->findAll();
        return $this->render('commentaire/affichercommentaire.html.twig', [
            'commentaires' => $commentaire,
        ]);
    }
    #[Route('/deletecommentaire/{id}', name: 'app_deletecommentaire')]
    public function deletecommentaire(Commentaire $commentaire = null, ManagerRegistry $doctrine, $id): RedirectResponse
    {
        if ($commentaire) {
            $manager = $doctrine->getManager();

            $manager->remove($commentaire);
            $manager->flush();
            $this->addFlash('success', 'la commentaire a ete supprimé avec succe');

        } else {
            $this->addFlash('error', 'la commentaireinexistant');

        }
        return $this->redirectToRoute('app_affichercommentaire');

    }
}
