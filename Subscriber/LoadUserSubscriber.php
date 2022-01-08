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
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private UserProviderInterface $userProvider
    ) {}

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

    public function onPayloadValid(PayloadValidEvent $event): void
    {
        $communityId = $event->getCommunityId();

        try {
            $user = $this->userProvider->loadUserByIdentifier($communityId);
        } catch (UsernameNotFoundException $e) {
            $this->eventDispatcher->dispatch(new FirstLoginEvent($communityId), FirstLoginEvent::NAME);

            return;
        }

        $this->eventDispatcher->dispatch(new AuthenticateUserEvent($user), AuthenticateUserEvent::NAME);
    }
}