<?php

namespace App\Controller;
use MercurySeries\FlashyBundle\FlashyNotifier;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Entity\Application;
use App\Form\ApplicationType;
use App\Repository\ApplicationRepository;
use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;

use Doctrine\ORM\QueryBuilder;


#[Route('/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $queryBuilder = $serviceRepository->createQueryBuilder('a')
        ->orderBy('a.clientPhone', 'ASC');
        $services = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            2 /*limit per page*/
        );
        return $this->render('service/index.html.twig', [
            
            'services' => $services,
        ]);
    }
    #[Route('/{id}/{role}/apply', name: 'app_service_apply', methods: ['GET', 'POST'])]
    public function apply(int $id, String $role, Request $request, FlashyNotifier $flashy ,ServiceRepository $serviceRepository, EntityManagerInterface $entityManager): Response
    {   $user = $entityManager->getRepository(User::class)->find(2);
        $application = $entityManager->getRepository(Application::class)->find($id);
        if (!$application) {
            throw $this->createNotFoundException('Application not found');
        }
        
        $service = new Service();
        $location = $request->request->get('location');
        $clientphone = $request->request->get('clientphone');
    
        if ($location && $clientphone) {
            
            $service->setLocation($location);
            $service->setOuvrier($application);
        
            $service->setIdClient($user);
            $service->setServicename($role);
            $service->setClientPhone($clientphone);
            $entityManager->persist($service);
            $entityManager->flush();
            sleep(5);
            return $this->redirectToRoute('app_home_client_success');
        }
    
        return $this->render('service/apply.html.twig', [
      
            'id' => $id,
            'role' => $role,
        ]);
    }
    #[Route('/tasks', name: 'app_service_tasks', methods: ['GET'])]
    public function tasks(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/tasks.html.twig', [
            'services' => $serviceRepository->findAll(),   
        ]);
    }
    #[Route('/history', name: 'app_service_history', methods: ['GET'])]
    public function history(ServiceRepository $serviceRepository): Response
    {
      
        return $this->render('service/history.html.twig', [
            'services' => $serviceRepository->findAll(),   
        ]);
    }
    #[Route('/new', name: 'app_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceRepository $serviceRepository): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->save($service, true);

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceRepository->save($service, true);

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, ServiceRepository $serviceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $serviceRepository->remove($service, true);
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
