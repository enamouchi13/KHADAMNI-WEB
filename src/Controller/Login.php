<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use App\Form\ForgetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;
use App\Form\LoginnType;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;



class Login extends AbstractController
{
    #[Route(path: '/loginn', name: 'loginn')]

    public function login(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(LoginnType::class);
        $error="";
        $e="";
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $e=$data["password"];
            $user = $entityManager->getRepository(Utilisateur::class)->findOneBy(['mail' => $data['mail']]);
            $factory = new PasswordHasherFactory([
                'common' => ['algorithm' => 'bcrypt'],
                'memory-hard' => ['algorithm' => 'sodium'],
            ]);

            $passwordHasher = $factory->getPasswordHasher('common');
            if($user) {
                if($data['password']) {
                    if ($passwordHasher->verify($user->getPassword(), $data['password'])) {
                        //$this->addFlash('Email ou mot de passe incorrect.');
                        $error="yes";
                        //return $this->redirectToRoute('loginn');
                    } else {
                        $error="votre mot de passe est incorrect";
                    }
                    // Authentification réussie : stockage de l'ID de l'utilisateur dans la session
                    $this->get('session')->set('user_id', $user->getId());
                        // Obtention de l'EntityManager
                    $entityManager = $this->getDoctrine()->getManager();

                        // Obtention de l'ID de l'utilisateur à partir de la session
                    $userID = $this->get('session')->get('user_id');

                        // Obtention du Repository de l'entité Utilisateur
                     $userRepository = $entityManager->getRepository(Utilisateur::class);

                        // Obtention de l'utilisateur à partir de son ID
                    $user = $userRepository->find($userID);

                        // Obtention du rôle de l'utilisateur
                        $role = $user->getRole();


                    // Redirection en fonction du rôle
                    switch ($role) {
                        case 'admin':
                            return $this->redirectToRoute('app_utilisateur_show');
                        case 'client':
                            return $this->redirectToRoute('app_utilisateur_new');
                        default:
                            return $this->redirectToRoute('app_utilisateur_new');
                    }
                } else {
                    $error="entrer votre mot mot de passe";
                }
            } else {
                $error="votre email existe pas";
            }
        }

        return $this->render('security/loginn.html.twig', [
            'form' => $form->createView(),
            'error'=> $error,
            'e'=>$e
        ]);
    }
}

    






