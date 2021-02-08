<?php

namespace Knojector\SteamAuthenticationBundle\Event;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * @author knojector <dev@knojector.xyz>
 */
abstract class CommunityIdAwareEvent extends Event
{
    /**
     * @var string
     */
    private $communityId;

    public function __construct(string $communityId)
    {
        $this->communityId = $communityId;
    }

    public function getCommunityId(): string
    {
        return $this->communityId;
    }
}