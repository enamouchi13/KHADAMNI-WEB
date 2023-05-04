<?php

namespace App\Controller;


use App\Entity\Produit;
use App\Repository\ProduitRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Twilio\Rest\Client;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, ProduitRepository $produitRepository)
    {
        $panier = $session->get("panier", []);


        $dataPanier = [];
        $total = 0;
        $totalcommande =0;
        $totaletva=0;

        foreach($panier as $id => $quantite){
            $produit = $produitRepository->find($id);

            $total = intval($produit->getPrix()) * $quantite;
            $dataPanier[] = [
                "produit" => $produit,
                "quantite" => $quantite,
                "total" => $total

            ];

            $totalcommande= $total+$totalcommande;
            $totaletva=  $totalcommande + ($totalcommande * 20 /100);
        }


        return $this->render('cart.html.twig', compact("dataPanier", "total" , "totalcommande","totaletva"));
    }
    #[Route("/add/{id}", name:"add")]
    public function add(Produit $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart");
    }
    #[Route("/remove/{id}", name:"remove")]
    public function remove(Produit $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart");
    }
    #[Route("/delete/{id}", name:"delete")]
    public function delete(Produit $product, SessionInterface $session)
    {
        // On récupère le panier actuel
        $panier = $session->get("panier", []);
        $id = $product->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("app_cart");
    }
    #[Route('/send', name: 'app_sms')]
    public function sendSms(SessionInterface $session,UtilisateurRepository $utilisateurRepository): Response
    {
        $myValue = $session->get('user_id');
        $u=$utilisateurRepository->find($myValue);

        $accountSid='AC721442f2869b03544ddee1d326e0d2ef';
        $authToken='bf7ad21c2fd3774d8cab7b5b40e80776';
        $twilio= new Client($accountSid,$authToken);
        $message = $twilio->messages->create('+216'.$u->getTel(),array( 'from'=>'+16205088906','body'=>'Votre Achat etait un succes'));
        if ($message->sid) {
            $sms= 'SMS sent successfully.';
        } else {
            $sms ='Failed to send SMS.';
        }
        return $this->redirectToRoute("app_cart");
    }
}
