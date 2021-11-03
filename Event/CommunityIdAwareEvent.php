<?php

namespace Knojector\SteamAuthenticationBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author knojector <dev@knojector.xyz>
 */
abstract class CommunityIdAwareEvent extends Event
{
    public function __construct(private string $communityId)
    {}

    public function getCommunityId(): string
    {
        return $this->communityId;
    }
}