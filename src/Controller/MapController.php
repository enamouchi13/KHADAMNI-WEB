<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    #[Route('/map', name: 'app_map')]
    public function showMap(): Response
    {
        return $this->render('map.html.twig', [
            'controller_name' => 'MapController',
        ]);
    }
    #[Route('/map/{id}', name: 'app_map_show', methods: ['GET'])]
    public function show(String $id): Response
    {
        return $this->render('map1.html.twig', [
            'location' => $id,
        ]);
    }


}
