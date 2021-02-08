<?php

namespace Knojector\SteamAuthenticationBundle\Subscriber;

use Knojector\SteamAuthenticationBundle\Event\AuthenticateUserEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * @author knojector <dev@knojector.xyz>
 */
class AuthenticateUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        RequestStack $requestStack,
        SessionInterface $session,
        TokenStorageInterface $tokenStorage
    ) {
      $this->eventDispatcher = $eventDispatcher;
      $this->request = $requestStack->getCurrentRequest();
      $this->session = $session;
      $this->tokenStorage = $tokenStorage;
    }

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

    public function onAuthenticateUser(AuthenticateUserEvent $event)
    {
        $user = $event->getUser();

        $token = new UsernamePasswordToken($user, null, 'steam', $user->getRoles());
        $this->tokenStorage->setToken($token);
        $this->session->set('_security_steam', serialize($token));

        $event = new InteractiveLoginEvent($this->request, $token);
        $this->eventDispatcher->dispatch($event, 'security.interactive_login');
    }
}