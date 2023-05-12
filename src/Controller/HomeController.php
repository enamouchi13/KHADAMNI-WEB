<?php

namespace App\Controller;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(FlashyNotifier $flashy): Response
    {
        $flashy->primaryDark('Bienvenue Monsieur!', 'http://your-awesome-link.com');
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    #[Route('/home/success', name: 'app_home_success')]
    public function success(FlashyNotifier $flashy): Response
    {
        $flashy->primaryDark('Votre Application a etait ajoute avec succes!', 'http://your-awesome-link.com');
        return $this->render('home/success.html.twig', [
            
        ]);
    }
    #[Route('/access', name: 'app_home_access')]
    public function access(): Response
    {
        return $this->render('home/access.html.twig', [
            
        ]);
    }
    
}
