<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginFormAuthAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private $session;
    


    public function __construct(private UrlGeneratorInterface $urlGenerator,SessionInterface $session)
    {
        $this->urlGenerator = $urlGenerator;
        $this->session = $session;
    }

    public function authenticate(Request $request): Passport
    {
        $mail = $request->request->get('mail', '');

        $request->getSession()->set(Security::LAST_USERNAME, $mail);

        return new Passport(
            new UserBadge($mail),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {   
        $user = $token->getUser();

        $this->session->set('user_id', $user->getId());
        $this->session->set('user_email', $user->getEmail());
    
        // redirect the user to where they were before the login process begun.
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }
    
        // For example:
        return new RedirectResponse($this->urlGenerator->generate('app_utilisateur_show'));
       
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
         return new RedirectResponse($this->urlGenerator->generate('app_test'));
        //throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
