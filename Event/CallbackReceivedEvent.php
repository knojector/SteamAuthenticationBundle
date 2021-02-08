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

    /**
     * @var SteamCallback
     */
    protected $steamCallback;

    public function __construct(SteamCallback $steamCallback)
    {
        $this->steamCallback = $steamCallback;
    }

    public function getSteamCallback(): SteamCallback
    {
        return $this->steamCallback;
    }
}