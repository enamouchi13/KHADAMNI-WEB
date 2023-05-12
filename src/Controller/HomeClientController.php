<?php

namespace App\Controller;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeClientController extends AbstractController
{
    #[Route('/home/client', name: 'app_home_client')]
    public function index(): Response
    {
        return $this->render('home_client/index.html.twig', [
            'controller_name' => 'HomeClientController',
        ]);
    }
    #[Route('/home/client/success', name: 'app_home_client_success')]
    public function success(FlashyNotifier $flashy): Response
    { $flashy->primaryDark('Votre service a etait ajoute avec succes!', 'http://your-awesome-link.com');
        return $this->render('home_client/index.html.twig', [
            
        ]);
    }
}
