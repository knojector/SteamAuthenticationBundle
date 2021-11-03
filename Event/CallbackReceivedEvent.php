<?php

namespace Knojector\SteamAuthenticationBundle\Event;

use Knojector\SteamAuthenticationBundle\DTO\SteamCallback;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author knojector <dev@knojector.xyz>
 */
class CallbackReceivedEvent extends Event
{
    CONST NAME = 'knojector.steam_authentication_bundle.callback_received';

    public function __construct(protected SteamCallback $steamCallback)
    {}

    public function getSteamCallback(): SteamCallback
    {
        return $this->steamCallback;
    }
}