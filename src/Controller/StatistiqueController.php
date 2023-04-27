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
use Dompdf\Options as DompdfOptions;






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
        /**
     * @Route("/stats1", name="stats1")
     */
    public function statistiques1(UtilisateurRepository $footRepo){
        // On va chercher toutes les menus
        $utilisateur = $footRepo->findAll();

//Data Category
        $puma = $footRepo->createQueryBuilder('a')
            ->select('count(a.id)')
            ->Where('a.role= :role')
            ->setParameter('role',"cliente")
            ->getQuery()
            ->getSingleScalarResult();

        $adidas = $footRepo->createQueryBuilder('a')
            ->select('count(a.id)')
            ->Where('a.role= :role')
            ->setParameter('role',"client")
            ->getQuery()
            ->getSingleScalarResult();




        return $this->render('statistique/stats1.html.twig', [
            'liv' => $puma,
            'cl' => $adidas,



        ]);

    }
    #[Route('/pdf', name: 'app_utilisateur_pdf', methods:['GET','Post'])]
    
            public function datapdf(UtilisateurRepository $utilisateurRepository): Response
            {
                $data = $utilisateurRepository->findAll();
            
                $pdfOptions = new DompdfOptions();
                $pdfOptions->set('defaultFont', 'Arial');
                $pdfOptions->setIsRemoteEnabled(true);
            
                // On instancie Dompdf
            
                $dompdf = new Dompdf($pdfOptions);
                $context = stream_context_create([
                    'ssl' => [
                        'verify_peer' => FALSE,
                        'verify_peer_name' => FALSE,
                        'allow_self_signed' => TRUE
                    ]
                ]);
            
                $dompdf->setHttpContext($context);
                $html = $this->renderView('statistique/pdf.html.twig', [
                    'utilisateur' => $data,
                ]);
                // Load HTML to Dompdf
                $dompdf->loadHtml($html);
            
                // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
                $dompdf->setPaper('A4', 'portrait');
            
                // Render the HTML as PDF
                $dompdf->render();
            
                $fichier = 'utilisateur.pdf';
                $dompdf->stream($fichier, [
                    "Attachment" => true
                ]);
            
                return new Response();
            }
        }
  





















    

