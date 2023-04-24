<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use PHPExcel;
use PHPExcel_IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class StatistiqueController extends AbstractController
{
    #[Route('/statistique', name: 'app_statistique')]
    public function index(): Response
    {
        return $this->render('statistique/index.html.twig', [
            'controller_name' => 'StatistiqueController',
        ]);
    

    }

        /**
         * @Route("/stats", name="stats")
         */
        public function statistiques(EntityManagerInterface $entityManager)
        {
            $userRepository = $entityManager->getRepository(Utilisateur::class);
            $nombreUtilisateurs = $userRepository->count(['role' => 'client']);
    
            $utilisateurs = $userRepository->findBy(['role' => 'client']);
    
            $cinData = [];
            $telephoneData = [];
    
            foreach ($utilisateurs as $utilisateur) {
                $cinData[] = $utilisateur->getCin();
                $telephoneData[] = $utilisateur->getTel();
            }
    
            // Reste du code
    
            return $this->render('statistique/statit.html.twig', [
                'cinData' => json_encode($cinData),
                'telephoneData'=> json_encode($telephoneData),
                'nombreUtilisateurs' => $nombreUtilisateurs,
            ]);
        }



        
        // Reste du code
    }

  


    

