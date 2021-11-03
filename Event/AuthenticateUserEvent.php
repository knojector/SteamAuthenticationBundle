<?php

namespace Knojector\SteamAuthenticationBundle\Event;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author knojector <dev@knojector.xyz>
 */
class AuthenticateUserEvent extends Event
{
    CONST NAME = 'knojector.steam_authentication_bundle.authenticate_user';

    public function __construct(protected UserInterface $user)
    {}

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}