<?php

namespace Knojector\SteamAuthenticationBundle\Event;

/**
 * @author knojector <dev@knojector.xyz>
 */
class PayloadValidEvent extends CommunityIdAwareEvent
{
    CONST NAME = 'knojector.steam_authentication_bundle.payload_valid';
}