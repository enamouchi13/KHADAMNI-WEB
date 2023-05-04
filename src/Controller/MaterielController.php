<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\CategorieRepository;
use App\Repository\MaterielRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class MaterielController extends AbstractController
{
    #[Route('/materiel', name: 'app_materiel')]
    public function index(): Response
    {
        return $this->render('materiel/index.html.twig', [
            'controller_name' => 'MaterielController',
        ]);
    }

    #[Route('/addmateriel/{id?0}', name: 'app_addmateriel')]
    public function addMateriel(Materiel $materiel=null,ManagerRegistry $doctrine,Request $request,SluggerInterface $slugger): Response
    {
        $new=false;
        if(!$materiel)
        {    $new=true;
            $materiel=new Materiel();


        }
        $form=$this->createForm(MaterielType::class,$materiel);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() )
        {


            $entitymanager=$doctrine->getManager();


            $imageFile = $form->get('image')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $materiel->setImage($newFilename);
            }
            $entitymanager->persist($materiel);
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
            return $this->redirectToRoute('app_affichemateriel');






        }
        else
        {
            return $this->render('materiel/addmateriel.html.twig', [
                'form'=>$form->createView(),
            ]);



        }


    }
    #[Route('/affichemateriel', name: 'app_affichemateriel')]
    public function afficherResponse(ManagerRegistry $doctrine): Response
    {

        $repository=$doctrine->getRepository(Materiel::class);
        $materiel=$repository->findAll();
        return $this->render('materiel/affichermateriel.html.twig', [
            'materiels' => $materiel,
        ]);








    }


    #[Route('/deletemateriel/{id}', name: 'app_deletemateriel')]
    public function deleteResponse(Materiel $materiel = null, ManagerRegistry $doctrine, $id): RedirectResponse
    {
        if ($materiel) {
            $manager = $doctrine->getManager();

            $manager->remove($materiel);
            $manager->flush();
            $this->addFlash('success', 'le materiel a ete supprimé avec succe');

        } else {
            $this->addFlash('error', 'le materile inexistant');

        }
        return $this->redirectToRoute('app_affichemateriel');

    }





    #[Route('/statistique', name: 'app_statistiqueemna')]
    public function statistique(CategorieRepository $categorierepository, MaterielRepository $materielrepository): Response
    {
        $categories=$categorierepository->findAll();


        $categorieNom=[];
        $categorieCount=[];
        foreach ($categories as $categorie )
        {
            $categorieNom[]=$categorie->getNomc();
            $materiels = $materielrepository->findByCategorie($categorie);

            $categorieCount[]=count($materiels);


        }



        return $this->render('materiel/statistique.html.twig',[
            'categNom'=>json_encode($categorieNom),
            'catacount'=>json_encode($categorieCount)


        ]);
    }




    #[Route('/addfrontmaterial', name: 'app_addfrontmaterial')]
    public function addMaterielFront(ManagerRegistry $doctrine, Request $request,SluggerInterface $slugger): Response

    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $entitymanager=$doctrine->getManager();


            $imageFile = $form->get('image')->getData();

            if ($imageFile)
            {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $imageFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $materiel->setImage($newFilename);
            }
            $entitymanager->persist($materiel);
            $entitymanager->flush();
            return $this->redirectToRoute('app_homefourniseur');

        }
        else {

            return $this->render('materiel/addmaterielfront.html.twig', [
                'form'=>$form->createView(),
            ]);

        }





    }








}
