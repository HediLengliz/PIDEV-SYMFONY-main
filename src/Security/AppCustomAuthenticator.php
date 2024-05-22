<?php

namespace App\Security;

use App\Service\TwilioService;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class AppCustomAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';
    private SessionInterface $session;
    
    public function __construct(public TwilioService $smsGenerator,private UrlGeneratorInterface $urlGenerator,SessionInterface $session)
   {
    $this->urlGenerator = $urlGenerator;
    $this->session = $session;
    }

    public function authenticate(Request $request): Passport
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);
        
        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
                new RememberMeBadge(),
            ]
        );
    }
public function sendSms(TwilioService $smsGenerator)
   {
      
        // Numéro vérifier par twilio. Un seul numéro autorisé pour la version de test.

       //Appel du service
       $code =$this->generateSixDigitCode();
       $this->session->set('authentication_code', 123);

       // Set a flag to indicate that the user has completed the first factor
       $this->session->set('2fa_authenticated', true);
    //    $smsGenerator->sendSms('+21692741748' ,$code);

     
   }
   function generateSixDigitCode(): int
{
    return mt_rand(100000, 999999);
}

public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
{
    $user = $token->getUser();

    if ($user instanceof \App\Entity\User) {
        // Assuming your User entity has a method getId()
        if ($this->session->get('2fa_authenticated')) {
            // User has completed the second factor, proceed with the regular authentication success logic
            return null; // Allow Symfony to handle the success redirect
        }

        // Generate a 6-digit code

        // Store the code in the session


        // Send the SMS with the generated code
        $this->sendSms($this->smsGenerator);

        // Redirect to the 2FA page with the user ID as a query parameter
        $url = $this->urlGenerator->generate('two_factor_authentication');

        return new RedirectResponse($url);
    }
}
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
