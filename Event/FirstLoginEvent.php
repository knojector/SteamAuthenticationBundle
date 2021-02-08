<?php

namespace Knojector\SteamAuthenticationBundle\Event;

/**
 * @author knojector <dev@knojector.xyz>
 */
class FirstLoginEvent extends CommunityIdAwareEvent
{
    CONST NAME = 'knojector.steam_authentication_bundle.first_login';
}