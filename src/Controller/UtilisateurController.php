<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;




#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{
    #[Route('/', name: 'app_utilisateur_index', methods: ['GET'])]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }
    

#[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
public function new(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordEncoderInterface $encoder): Response
{
    $utilisateur = new Utilisateur();
    $form = $this->createForm(UtilisateurType::class, $utilisateur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Set the password for the new user
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);
        $passwordHasher = $factory->getPasswordHasher('common');
        $hash = $passwordHasher->hash($utilisateur->getPassword());
        $utilisateur->setPassword($hash);

        // Save the new user to the database
        $utilisateurRepository->save($utilisateur, true);

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('utilisateur/new.html.twig', [
        'utilisateur' => $utilisateur,
        'form' => $form,
    ]);
} 
/*
#[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
public function new(Request $request, UtilisateurRepository $utilisateurRepository, UserPasswordEncoderInterface $encoder, SessionInterface $session): Response
{
    $utilisateur = new Utilisateur();
    $utilisateur->setEncoder($encoder); // appel de la méthode setEncoder() pour initialiser l'attribut $encoder
    $form = $this->createForm(UtilisateurType::class, $utilisateur);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Set the password for the new user
        $password = $form->get('password')->getData();
        $utilisateur->setPassword($password);

        // Save the new user to the database
        $utilisateurRepository->save($utilisateur, true);

        // Ajouter l'utilisateur créé à la session
        $session->set('user', $utilisateur);

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->renderForm('utilisateur/new.html.twig', [
        'utilisateur' => $utilisateur,
        'form' => $form,
    ]);
}*/



    
    #[Route('/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateurRepository->save($utilisateur, true);

            return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    public function delete(Request $request, Utilisateur $utilisateur, UtilisateurRepository $utilisateurRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $utilisateurRepository->remove($utilisateur, true);
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
