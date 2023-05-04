<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategorieType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    #[Route('/back', name: 'app_back')]
    public function show_back(): Response
    {
        return $this->render('back.html.twig'

        );
    }
    #[Route('/addcc/{id?0}', name: 'app_add')]
    public function addCategorie(ManagerRegistry $doctrine, Request $request,Categorie $categorie=null): Response
    {

        $new=false;
        if(!$categorie)
        {    $new=true;
            $categorie=new Categorie();


        }
        $form=$this->createForm(CategorieType::class,$categorie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $entitymanager=$doctrine->getManager();
            $entitymanager->persist($categorie);
            $entitymanager->flush();
            if($new)
            {
                $message="a eté ajouté avec succes";
            }
            else
            {$message="a eté modifié avec succes";

            }


            $this->addFlash('success', $message);
            //$form->getData();
            return $this->redirectToRoute('app_affichecategorie');




        }
        else {
            return $this->render('categorie/add.html.twig',[
                    'form'=>$form->createView(),
                ]

            );



        }




    }

    #[Route('/afficher', name: 'app_affichecategorie')]
    public function afficherCategorie(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Categorie::class);
        $categorie=$repository->findAll();
        return $this->render('categorie/afficher.html.twig', [
            'categories' => $categorie,
        ]);
    }
    #[Route('/deleter/{id}', name: 'app_deletecategorie')]
    public function deleteResponse(Categorie $categorie = null, ManagerRegistry $doctrine, $id): RedirectResponse
    {
        if ($categorie) {
            $manager = $doctrine->getManager();

            $manager->remove($categorie);
            $manager->flush();
            $this->addFlash('success', 'la categorie a ete supprimé avec succe');

        } else {
            $this->addFlash('error', 'la categorie inexistant');

        }
        return $this->redirectToRoute('app_affichecategorie');

    }
}
