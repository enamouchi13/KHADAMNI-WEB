<?php

namespace App\Controller;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use App\Repository\CommentaireRepository;
use App\Repository\UtilisateurRepository;
use App\Service\WordFilterService;

use DateTime;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }
    #[Route('/addpost/{id?0}', name: 'app_addpost')]
    public function add_post(Post $post=null,ManagerRegistry $doctrine,Request $request,SluggerInterface $slugger): Response
    {
        $new=false;
        if(!$post)
        {    $new=true;
            $post=new Post();


        }
        $form=$this->createForm(PostType::class,$post);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() )
        {
            $post->setCreatedAt(new \DateTime());
            $entitymanager=$doctrine->getManager();
            $imageFile = $form->get('image')->getData();
            if($imageFile)
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
                $post->setImage($newFilename);
            }



            $entitymanager->persist($post);
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
            return $this->redirectToRoute('app_afficherpost');


        }
        else {



            return $this->render('post/addpost.html.twig',[
                    'form'=>$form->createView(),

                ]

            );


        }


    }

    #[Route('/afficherpost', name: 'app_afficherpost')]
    public function afficherPost(ManagerRegistry $doctrine): Response
    {
        $repository=$doctrine->getRepository(Post::class);
        $post=$repository->findAll();
        return $this->render('post/afficherpost.html.twig', [
            'posts' => $post,
        ]);
    }
    #[Route('/deletepost/{id}', name: 'app_deletepost')]
    public function deleteResponse(Post $post = null, ManagerRegistry $doctrine, $id): RedirectResponse
    {
        if ($post) {
            $manager = $doctrine->getManager();

            $manager->remove($post);
            $manager->flush();
            $this->addFlash('success', 'l article a ete supprimé avec succe');

        } else {
            $this->addFlash('error', 'l article inexistant');

        }
        return $this->redirectToRoute('app_afficherpost');

    }

#[Route('/detail/{id<[0-9]+>}', name: 'app_detailpost')]
public function detailpost( ManagerRegistry $doctrine, $id,Request $request,SessionInterface $session,UtilisateurRepository $utilisateurRepository,CommentaireRepository $commentaireRepository,WordFilterService $wordFilter): Response
{$entitymanager=$doctrine->getManager();
   $comment=new Commentaire();
    $repository = $doctrine->getRepository(Post::class);
    $post = $repository->find($id);
    $comment->setArticle($post);
   $form=$this->createForm(CommentaireType::class,$comment);
   $form->handleRequest($request);
    $myValue = $session->get('user_id');
    $u=$utilisateurRepository->find($myValue);

    if($form->isSubmitted() && $form->isValid())
   {
       //recuperer la session utulisateur


       $comment->setNameUser($u->getPrenom());

       $comment->setContent($wordFilter->filterWords($comment->getContent()));
       $entitymanager->persist($comment);
       $entitymanager->flush();
       //rediretion to ???




   }


    if (!$post) {

        return $this->redirectToRoute('app_afficherpostfront');
    }

    return $this->render('post/afficherpostfront.html.twig', [
        'post' => $post,
        'form' => $form->createView(),
        'user' =>$u,
        'comments'=>$commentaireRepository->findBy(['article'=>$post]),
    ]);


}
    #[Route('/addpostfront', name: 'app_addpostfront')]
    public function addPostFront(ManagerRegistry $doctrine, Request $request,SluggerInterface $slugger,SessionInterface $session,UtilisateurRepository $utilisateurRepository): Response
    {
        $myValue = $session->get('user_id');
        $u=$utilisateurRepository->find($myValue);
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);


        $form->handleRequest($request);
        $entitymanager = $doctrine->getManager();
        if($form->isSubmitted() && $form->isValid())
        {


            $imageFile = $form->get('image')->getData();

            if($imageFile){
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
                $post->setImage($newFilename);





            }
            $entitymanager->persist($post);
            $entitymanager->flush();

            return $this->redirectToRoute('app_afficherpostfront');



        }
        else
        {
            return $this->render('post/add-postfront.html.twig', [
                    'form' => $form->createView(),
                    'post'=>$post,
                    'user' => $u,



                ]

            );


        }


    }


}
