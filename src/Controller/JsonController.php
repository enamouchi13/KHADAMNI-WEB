<?php

namespace App\Controller;
use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
 use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Validator\Constraints\Json;

use App\Entity\Utilisateur;
use App\Entity\Produit;
use App\Entity\Ctaegories;
use App\Form\UtilisateurType;
use App\Form\ProduitType;
use App\Form\CategoriesType;
use Doctrine\ORM\QueryBuilder;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\Security\Core\Encoder\PasswordHasherFactoryInterface;



use Doctrine\ORM\EntityManagerInterface;

class JsonController extends AbstractController{

/*****************       Ajouter un user lel mobile bel json  ********************************/

 /**
 * @Route("/utilisateurr/neww", name="app_utilisateur_new")
 *@Method({"GET", "POST"})
 */
 public function new(Request $request)
 {
     $utilisateur = new Utilisateur();
    
     $utilisateur->setCin($request->query->get("cin"));
     $utilisateur->setNom($request->query->get("nom"));
     $utilisateur->setPrenom($request->query->get("prenom"));
 
     if ($request->query->has("password")) {
         $utilisateur->setPassword($request->query->get("password"));
     }
 
     if ($request->query->has("mail")) {
         $utilisateur->setMail($request->query->get("mail"));
     }
 
     $utilisateur->setRole($request->query->get("role"));
     $utilisateur->setTel($request->query->get("tel"));
 
     $em = $this->getDoctrine()->getManager();
     $em->persist($utilisateur);
     $em->flush();
     $serializer = new Serializer([new ObjectNormalizer()]);
     $formatted = $serializer->normalize($utilisateur);
     return new JsonResponse($formatted);
 }

 

/******************** show json ***********************************/
#[Route('/utilisateur/showw/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
public function show($id): JsonResponse
{
    $utilisateur = $this->getDoctrine()->getManager()->getRepository(Utilisateur::class)->find($id);
    $serializer = new Serializer([new ObjectNormalizer()]);
    $formated = $serializer->normalize($utilisateur);
    return new JsonResponse(['utilisateur' => $formated]);
}


/********************** modifier bel mobile o zedt l json  *********************** */

/**
 * @Route("/{id}/editt", name="app_utilisateur_edit")
 * @Method("POST")  
 */

 public function edit(Request $request, Utilisateur $utilisateur)
 {
     $utilisateur->setCin($request->query->get("cin"));
     $utilisateur->setNom($request->query->get("nom"));
     $utilisateur->setPrenom($request->query->get("prenom"));
 
     if ($request->query->has("password")) {
         $utilisateur->setPassword($request->query->get("password"));
     }
 
     if ($request->query->has("mail")) {
         $utilisateur->setMail($request->query->get("mail"));
     }
 
     $utilisateur->setRole($request->query->get("role"));
     $utilisateur->setTel($request->query->get("tel"));
 
     $em = $this->getDoctrine()->getManager();
     $em->persist($utilisateur);
     $em->flush();
     $serializer = new Serializer([new ObjectNormalizer()]);
     $formatted = $serializer->normalize($utilisateur);
     return new JsonResponse($formatted);
 }
 

/**
 * @Route("/loginnn", name="app_utilisateur_login")
 * @Method("POST")  
 */
 public function login(Request $request): JsonResponse
 {
     $mail = $request->query->get('mail');
     $password = $request->query->get('password');
 
     $entityManager = $this->getDoctrine()->getManager();
     $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['mail' => $mail]);
 
     if ($user) {
         if ($user->getPassword() === $password) {
             // les identifiants sont corrects
             return new JsonResponse(['success' => 'Vous etes connecte avec success,welcome']);
         } else {
             // le mot de passe est incorrect
             return new JsonResponse(['error' => 'Votre mot de passe est incorrect'], 401);
         }
     } else {
         // l'adresse email n'existe pas
         return new JsonResponse(['error' => 'Votre email n\'existe pas'], 404);
     }
 }
 


/**
     * @Route("/utilisateurr/{id}", name="SupprimerUtilisateur")
     * @Method("DELETE")
     */

public function delete_utilisateur(Request $request)
    {
        $id = $request->get("id");
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository(Utilisateur::class)->find($id);
        if($utilisateur != null)
        {
            $em->remove($utilisateur);
            $em->flush();
            $serializer = new Serializer([new ObjectNormalizer()]);
            $formated = $serializer->normalize(" utilisateur ete supprimer avec succées ");
            return new JsonResponse($formated);

        }
        return new JsonResponse("id utilisateur est invalide !");
    } 

    

  
    #[Route('/allapps', name: 'application')]
    public function getAllApplications(ApplicationRepository $repo, SerializerInterface $serializer)
    {
        
        $applications =  $repo->findAll();

        $json = $serializer->serialize($applications, 'json');

      

        return new Response($json);
    }
    
    #[Route('/allservices', name: 'service')]
    public function getAllServices(ServiceRepository $repo, SerializerInterface $serializer)
    {
        
        $services =  $repo->findAll();

        $json = $serializer->serialize($services, 'json');    

        return new Response($json);
    }

    #[Route('/services/{id}', name: 'serviceid')]
    public function getServiceID($id,ServiceRepository $repo, SerializerInterface $serializer)
    {
        
        $services =  $repo->find($id);

        $json = $serializer->serialize($services, 'json');

      

        return new Response($json);
    }
    #[Route('/applications/{id}', name: 'applicationid')]
    public function getApplicationID($id,ApplicationRepository $repo, SerializerInterface $serializer)
    {
        
        $applications =  $repo->find($id);

        $json = $serializer->serialize($applications, 'json');

      

        return new Response($json);
    }
    

    #[Route('/delser', name: 'delser', methods: ['GET', 'POST'])]
    public function deleteService(Request $request) {
         $id = $request->get("id");

         $em = $this->getDoctrine()->getManager();
         $reclamation = $em->getRepository(Service::class)->find($id);
         if($reclamation!=null ) {
             $em->remove($reclamation);
             $em->flush();

             $serialize = new Serializer([new ObjectNormalizer()]);
             $formatted = $serialize->normalize("Reclamation a ete supprimee avec success.");
             return new JsonResponse($formatted);

         }
         return new JsonResponse("id reclamation invalide.");


     }
     #[Route('/delapp', name: 'delapp', methods: ['GET', 'POST'])]
     public function deleteApp(Request $request) {
         $id = $request->get("id");

         $em = $this->getDoctrine()->getManager();
         $reclamation = $em->getRepository(Application::class)->find($id);
         if($reclamation!=null ) {
             $em->remove($reclamation);
             $em->flush();

             $serialize = new Serializer([new ObjectNormalizer()]);
             $formatted = $serialize->normalize("Reclamation a ete supprimee avec success.");
             return new JsonResponse($formatted);

         }
       
        }

         #[Route('/newser', name: 'new_ser')]
    public function newser (UserRepository $userrepository, ApplicationRepository $apprepository , Request $rq, NormalizerInterface $Normalizer)
         {
            
             $client = $userrepository -> find($rq -> get('idc'));
             $ouvrier = $apprepository -> find($rq -> get('ido'));
     
             $em = $this->getDoctrine()->getManager();
             $service= new Service();
        $service->setIdClient($client);
        $service->setLocation($rq -> get('loc'));
      
        $service->setClientPhone($rq -> get('ph'));
        $service->setServicename($rq -> get('ser'));
        $service->setOuvrier($ouvrier);
        $em->persist($service);
        $em->flush();
     
             $jsonContent = $Normalizer->normalize($service, 'json');
             return new Response(json_encode($jsonContent));
     
             
         }


         #[Route("addProduitJSON/new", name: "kist")]
         public function addProduitJSON(Request $req,NormalizerInterface $Normalizer)
         {
     
             $em = $this->getDoctrine()->getManager();
             $produit = new Produit();
             $produit->setNom($req->get('nom'));
             $produit->setPrix($req->get('prix'));
             $produit->setStock($req->get('stock'));
            
             $em->persist($produit);
             $em->flush();
     
             $jsonContent = $Normalizer->normalize($produit, 'json', ['groups' => 'products']);
             return new Response(json_encode($jsonContent));
         }
     
         #[Route('/Allproduits', name: 'app_affichejson')]
         public function Allproduits(ManagerRegistry $doctrine, SerializerInterface $serializer):JsonResponse
         {
             $repository = $doctrine->getRepository(Produit::class);
             $produit = $repository->findAll();
     
             $produitNormalises = $serializer->normalize($produit, null, ['groups' => 'produits']);
     
             return new JsonResponse($produitNormalises);
         }
     
         
     
         #[Route("deleteProduitJSON/{id}", name: "xist")]
         public function deleteProduitJSON(Request $req, $id, NormalizerInterface $Normalizer)
         {
     
             $em = $this->getDoctrine()->getManager();
             $produit = $em->getRepository(Produit::class)->find($id);
             $em->remove($produit);
             $em->flush();
             $jsonContent = $Normalizer->normalize($produit, 'json', ['groups' => 'students']);
             return new Response("Student deleted successfully " . json_encode($jsonContent));
         }
         
     
    
         #[Route("/AllCategories", name: "list")]
        
         public function getcategories(CategorieRepository $repo, SerializerInterface $serializer)
         {
             $categories= $repo->findAll();
             $json = $serializer->serialize($categories, 'json', ['groups' => "students"]);
             return new Response($json);
         }
         
         #[Route("addcategoriestJSON/new", name: "pist")]
         public function addcategoriestJSON(Request $req,   NormalizerInterface $Normalizer)
         {
     
             $em = $this->getDoctrine()->getManager();
             $Categorie = new Categorie();
             $Categorie->setLibelle($req->get('libelle'));
             $Categorie->setQuantite($req->get('quantite'));
             $em->persist($Categorie);
             $em->flush();
     
             $jsonContent = $Normalizer->normalize($Categorie, 'json', ['groups' => 'students']);
             return new Response(json_encode($jsonContent));
         }
     
     
     
     
     #[Route('/affiche', name: 'app-afficher')]
     
         public function afficher(ManagerRegistry $doctrine):Response
         {
             $repository=$doctrine->getRepository(Categorie::class);
             $categorie=$repository->findAll();
             return $this->render('categorie/afficher.html.twig',[
     
                 'categories'=>$categorie
             ]);
     
     
         }
     
         #[Route("updateCategorieJSON/{id}", name: "nist")]
         public function updateCategorieJSON(Request $req, $id, NormalizerInterface $Normalizer)
         {
     
             $em = $this->getDoctrine()->getManager();
             $categorie = $em->getRepository(Categorie::class)->find($id);
             $categorie->setLibelle($req->get('libelle'));
             $categorie->setQuantite($req->get('quantite'));
             $em->flush();
     
             $jsonContent = $Normalizer->normalize($categorie, 'json', ['groups' => 'students']);
             return new Response("category updated successfully " . json_encode($jsonContent));
         }
     
     
     
     
     
         #[Route("deleteCategorieJSON/{id}", name: "wilt")]
         public function deleteCategorieJSON(Request $req, $id, NormalizerInterface $Normalizer)
         {
     
             $em = $this->getDoctrine()->getManager();
             $categorie = $em->getRepository(Categorie::class)->find($id);
             $em->remove($categorie);
             $em->flush();
             $jsonContent = $Normalizer->normalize($categorie, 'json', ['groups' => 'students']);
             return new Response("Student deleted successfully " . json_encode($jsonContent));
         }
     
     
         #[Route("updateCategorieJSON/{id}", name: "app_categorieadd")]
         public function updateStudentJSON(Request $req, $id, NormalizerInterface $Normalizer)
         {
     
             $em = $this->getDoctrine()->getManager();
             $categorie = $em->getRepository(Categorie::class)->find($id);
             $categorie->setNsc($req->get('libelle'));
             $categorie->setEmail($req->get('quantite'));
     
             $em->flush();
     
             $jsonContent = $Normalizer->normalize($categorie, 'json', ['groups' => 'students']);
             return new Response("Categorie updated successfully " . json_encode($jsonContent));
         }
        
     
        }              




















  
