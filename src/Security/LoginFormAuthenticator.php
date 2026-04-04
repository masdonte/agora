<?php

namespace App\Security;
use App\Entity\LoginTrace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(private UrlGeneratorInterface $urlGenerator, private EntityManagerInterface $em)
    {
    }

    public function authenticate(Request $request): Passport
    {
        $username = $request->getPayload()->getString('username');

        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $username);

        return new Passport(
            new UserBadge($username),
            new PasswordCredentials($request->getPayload()->getString('password')),
            [
                new CsrfTokenBadge('authenticate', $request->getPayload()->getString('_csrf_token')),
            ]
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $this->logLoginAttempt($request, $token->getUser()->getUserIdentifier(), true, 'Connexion réussie');
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        // For example:
        return new RedirectResponse($this->urlGenerator->generate('accueil'));
        throw new \Exception('TODO: provide a valid redirect inside ' . __FILE__);
    }
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $username = $request->request->get('username', '');
        $this->logLoginAttempt($request, $username, false, $exception->getMessageKey());
        // Enregistre le message d’erreur dans la session
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        $request->getSession()->set(Security::LAST_USERNAME, $username);
        // Redirige vers la page de login
        return new RedirectResponse($this->urlGenerator->generate(self::LOGIN_ROUTE));
    }
    private function logLoginAttempt(Request $request, string $username, bool $success, ?string $message = null): void
    {
        $trace = new LoginTrace();
        $trace->setUsername($username);
        $trace->setIpAddress($request->getClientIp() ?? 'unknown');
        $trace->setSuccess($success);
        $trace->setMessage($message);
        $trace->setLoggedAt(new \DateTimeImmutable());
        $this->em->persist($trace);
        $this->em->flush();
    }
    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
