<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapsController extends AbstractController
{
    #[Route('/map', name: 'map')]
    public function mapppp(): Response
    {
        return $this->render('maps/index.html.twig');
    }
}
