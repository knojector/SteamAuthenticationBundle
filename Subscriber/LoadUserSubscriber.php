<?php

namespace Knojector\SteamAuthenticationBundle\Subscriber;

use Knojector\SteamAuthenticationBundle\Event\AuthenticateUserEvent;
use Knojector\SteamAuthenticationBundle\Event\FirstLoginEvent;
use Knojector\SteamAuthenticationBundle\Event\PayloadValidEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * @author knojector <dev@knojector.xyz>
 */
class LoadUserSubscriber implements EventSubscriberInterface
{
    /**
     * @var EventSubscriberInterface
     */
    private $eventDispatcher;

    /**
     * @var UserProviderInterface
     */
    private $userProvider;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        UserProviderInterface $userProvider
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->userProvider = $userProvider;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            PayloadValidEvent::NAME => [
                ['onPayloadValid', 10]
            ]
        ];
    }

    public function onPayloadValid(PayloadValidEvent $event)
    {
        $communityId = $event->getCommunityId();

        try {
            $user = $this->userProvider->loadUserByUsername($communityId);
        } catch (UsernameNotFoundException $e) {
            $this->eventDispatcher->dispatch(new FirstLoginEvent($communityId), FirstLoginEvent::NAME);

            return;
        }

        $this->eventDispatcher->dispatch(new AuthenticateUserEvent($user), AuthenticateUserEvent::NAME);
    }
}