<?php

namespace App\Controller;
use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Knp\Component\Pager\PaginatorInterface;

use Doctrine\ORM\QueryBuilder;
class FilterController extends AbstractController
{
    #[Route('/filter', name: 'app_filter')]
    public function index(Request $request, EntityManagerInterface $entityManager ,PaginatorInterface $paginator): Response
    {
        $location = $request->request->get('location');
        $role = $request->request->get('role');

        $applicationss = [];
        if ($location && $role) {
            $applicationss = $this->getDoctrine()
                ->getRepository(Application::class)
                ->findBy(['location' => $location, 'role' => $role]);
        }
        $applications = $paginator->paginate(
            $applicationss, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );

        return $this->render('filter.html.twig', [
            'applications' => $applications,
        ]);
    }
}
