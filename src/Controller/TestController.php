<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Materiel;
use App\Entity\Post;
use App\Repository\MaterielRepository;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController

{  
    
    #[Route('/test', name: 'app_afficherpostfront')]
    public function index(ManagerRegistry $doctrine,SessionInterface $session,UtilisateurRepository $utilisateurRepository): Response
    {
        $myValue = $session->get('user_id');
        $u=$utilisateurRepository->find($myValue);

        $repository=$doctrine->getRepository(Post::class);
        $post=$repository->findAll();

        return $this->render('test/index.html.twig', [
            'posts' => $post,
            'user' => $u
        ]);
    }

    #[Route('/ouvrier/{categoryId?}', name: 'app_homeouvrier')]
    public function showfront(Request $request, ManagerRegistry $doctrine, ProduitRepository $produitRepository, $categoryId = null): Response
    {
        $repository = $doctrine->getRepository(Categories::class);
        $categories = $repository->findAll();

        $produits = $produitRepository->findAll();
        $repository=$doctrine->getRepository(Post::class);
        $post=$repository->findAll();

        if ($categoryId) {
            $produits = $produitRepository->findByCategory($categoryId);
        }

        return $this->render('test/frontouvrier.html.twig', [
            'categorie' => $categories,
            'produit' => $produits,
            'posts' => $post,
        ]);
    }
    #[Route('/fourniseur', name: 'app_homefourniseur')]
    public function showfrontfourniseur(Request $request, ManagerRegistry $doctrine,MaterielRepository $materielRepository): Response
    {

        $repository = $doctrine->getRepository(Materiel::class);
        $materials = $repository->findAll();
        $repository=$doctrine->getRepository(Post::class);
        $post=$repository->findAll();
        return $this->render('test/frontfourniseur.html.twig',[

            'materials' =>$materials,
                'posts' => $post,
            ]

        );
    }



    
}
