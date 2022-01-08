<?php

namespace Knojector\SteamAuthenticationBundle\Subscriber;

use Knojector\SteamAuthenticationBundle\Event\AuthenticateUserEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @author knojector <dev@knojector.xyz>
 */
class AuthenticateUserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private TokenStorageInterface $tokenStorage,
        private RequestStack $requestStack,
    ) {}

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            AuthenticateUserEvent::NAME => [
                ['onAuthenticateUser', 10]
            ]
        ];
    }

    public function onAuthenticateUser(AuthenticateUserEvent $event): void
    {
        $user = $event->getUser();

        $token = new UsernamePasswordToken($user, 'steam', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->requestStack->getSession()->set('_security_steam', serialize($token));

        $event = new InteractiveLoginEvent($this->requestStack->getCurrentRequest(), $token);
        $this->eventDispatcher->dispatch($event, 'security.interactive_login');
    }
}