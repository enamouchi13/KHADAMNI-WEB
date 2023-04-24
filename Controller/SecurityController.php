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
use Google\Recaptcha\Recaptcha;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
public function login(AuthenticationUtils $authenticationUtils, AuthLogRepositery $authLogRepositery, Request $request): Response
{
    // if ($this->getUser()) {
    //     return $this->redirectToRoute('target_path');
    // }

    // get the login error if there is one
    $error = $authenticationUtils->getLastAuthenticationError();
    // last username entered by the user
    $lastUsername = $authenticationUtils->getLastUsername();

    // partie recaptcha attentionnnnnnnnnnnnn
    // recuperation de l adresse ip de user 
    $userIp = $request->getClientIp();
    $countOfRecentLoginFail = 0;
    if ($lastUsername) {
        $countOfRecentLoginFail = $authLogRepositery->getRecentAuthAttemptFailure($lastUsername, $userIp);
    }

    return $this->render('security/login.html.twig', [
        'countOfRecentLoginFail' => $countOfRecentLoginFail,
        'last_username' => $lastUsername,
        'error' => $error,
    ]);
}


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /*

    #[Route(path: '/Forget', name: 'app_forget')]
    public function forgetPassword(Request $request, UtilisateurRepository $utilisateurRepository, Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {
        $form = $this->createForm(forgetPasswordType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees= $form->getData();
            $utilisateur=$utilisateurRepository->findOneBy(['mail'=>$donnees]);
            if(!$utilisateur){
                $this->addFlash('danger','cette adresse n existe pas ');
                return $this->redirectToRoute("app_login");
            }
            $token = $tokenGenerator->generateToken();
            try {
                $utilisateur->setRestToken($token);
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($utilisateur);
                $entityManager->flush();
            } catch(\Exception $exception){
                $this->addFlash('warning','une erreur est survenue :'.$exception->getMessage());
                return $this->redirectToRoute("app_login");
            }
    
            $url =$this->generateUrl('app_reset_password',array('token'=>$token),UrlGeneratorInterface::ABSOLUTE_URL);
    
            //bundle Mailer 
            $message=(new Swift_Message("mot de passe oublié "))
            ->setFrom('maryem.benghouma@esprit.tn')
            ->setTo($utilisateur->getMail())
            ->setBody("<p>Bonjour Madame/Monsieur </p>votre demande de reinstallation de mot de passe a été effectué avec succées. veuillez cliquer svp sur le lien suivant :".$url,
            "text/html");
    
            // send mail 
            $mailer->send($message);   
            $this->addFlash('message','E-mail de réinstallation du mot de passe est envoyé :'.$exception->getMessage());
        }
    
        return $this->render("security/forgetPassword.html.twig",['form'=>$form->createView()]);
    }*/

    
    #[Route(path: '/Forget', name: 'app_forget')]
    public function forgetPassword(Request $request, UtilisateurRepository $utilisateurRepository, MailerInterface $mailer, TokenGeneratorInterface $tokenGenerator, UrlGeneratorInterface $urlGenerator): Response
    {
        $form = $this->createForm(ForgetPasswordType::class);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees= $form->getData();
            $utilisateur=$utilisateurRepository->findOneBy(['mail'=>$donnees]);
            if(!$utilisateur){
                $this->addFlash('danger','Cette adresse n\'existe pas.');
                return $this->redirectToRoute("app_login");
            }
            $token = $tokenGenerator->generateToken();
            try {
                $utilisateur->setRestToken($token);
                $entityManager=$this->getDoctrine()->getManager();
                $entityManager->persist($utilisateur);
                $entityManager->flush();
            } catch(\Exception $exception){
                $this->addFlash('warning','Une erreur est survenue :'.$exception->getMessage());
                return $this->redirectToRoute("app_login");
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
            return $this->redirectToRoute("app_login");
        }
    
        return $this->render("security/forgetPassword.html.twig",['form'=>$form->createView()]);
    }
    
    #[Route(path: '/resetpassword', name: 'app_reset_password')]
   
    public function resetpassword(): Response
    {
        return $this->redirectToRoute("app_login");
    }
    

    
}