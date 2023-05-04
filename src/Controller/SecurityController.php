<?php

namespace App\Controller;
use App\Entity\Utilisateur;
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
use Google\Recaptcha\Recaptcha;
use App\Form\LoginFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use App\Controller\UtilisateurController;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
/*
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
{
    // if ($this->getUser()) {
    //     return $this->redirectToRoute('target_path');
    // }

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();


    return $this->render('security/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error,
    ]);
}


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): RedirectResponse
    {
        return $this->redirectToRoute('app_login');
    }*/



   

    
    #[Route(path: '/Forget', name: 'app_forget')]
    public function forgetPassword(Request $request, UtilisateurRepository $utilisateurRepository, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(ForgetPasswordType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees= $form->getData();
            $donnees = $form->get('mail')->getData();
            $utilisateur = $utilisateurRepository->findOneBy(['mail' => $donnees]);
                 if(!$utilisateur){
                $this->addFlash('danger','Cette adresse n\'existe pas.');
                return $this->redirectToRoute("loginn");
            }
            $token = $tokenGenerator->generateToken();
            try {
                $utilisateur->setRestToken($token);
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($utilisateur);
                $entityManager->flush();
            } catch(\Exception $exception){
                $this->addFlash('warning','Une erreur est survenue :'.$exception->getMessage());
                return $this->redirectToRoute("loginn");
            }
    
            $url =$urlGenerator->generate('app_reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
    
            // Sending email using Symfony Mailer
            $email = (new Email())
                ->from('maryem.benghouma@esprit.tn')
                ->to($utilisateur->getMail())
                ->subject('Mot de passe oublié')
                ->html("<p>Bonjour Madame/Monsieur </p>votre demande de reinstallation de mot de passe a été effectué avec succées. veuillez cliquer svp sur le lien suivant :".$url);
    
            // Sending the email
            $mailer->send($email);
    
            $this->addFlash('message','E-mail de réinstallation du mot de passe a été envoyé.');
            return $this->redirectToRoute("loginn");
        }
    
        return $this->render("security/forgetPassword.html.twig",['form'=>$form->createView()]);
    }
    
    #[Route(path: '/resetpassword', name: 'app_reset_password')]
   
    public function resetpassword(): Response
    {
        return $this->redirectToRoute("loginn");
    }





    public function sendResetLink(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ForgetPasswordType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $utilisateur = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['mail' => $data['mail']]);
            if (!$utilisateur) {
                $this->addFlash('error', 'Adresse e-mail non valide.');
                return $this->redirectToRoute('forgot_password');
            }

            $resetToken = bin2hex(random_bytes(32));

            $utilisateur->setRestToken($resetToken);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            $this->sendResetPasswordEmail($utilisateur->getMail(), $resetToken, $mailer);

            $this->addFlash('success', 'Un e-mail de réinitialisation du mot de passe a été envoyé à votre adresse e-mail.');

            return $this->redirectToRoute('loginn');
        }

        return $this->render('security/forgetPassword.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function sendResetPasswordEmail(string $email, string $resetToken, MailerInterface $mailer)
    {
        $message = 'Voici votre e-mail de réinitialisation du mot de passe.';

        $email = (new Email())
            ->from('maryem.benghouma@esprit.tn')
            ->to($email)
            ->subject('Réinitialisez votre mot de passe')
            ->text($message);

        $mailer->send($email);
    }
}
    


    






 

    
