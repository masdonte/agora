<?php
namespace App\EventListener;
use App\Entity\LoginTrace;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Event\LogoutEvent;
class LogoutListener
{
    public function __construct(
        private EntityManagerInterface $em,
        private RequestStack $requestStack
    ) {
    }
    public function onLogout(LogoutEvent $event): void
    {
        $user = $event->getToken()?->getUser();
        // Si aucun utilisateur (par ex. déconnexion forcée)
        if (!$user) {
            return;
        }
        $request = $this->requestStack->getCurrentRequest();
        $trace = new LoginTrace();
        $trace->setUsername($user->getUserIdentifier());
        $trace->setIpAddress($request?->getClientIp() ?? 'unknown');
        $trace->setSuccess(true);
        $trace->setMessage('Déconnexion réussie');
        $trace->setLoggedAt(new \DateTimeImmutable());
        $this->em->persist($trace);
        $this->em->flush();
    }
}
