<?php

namespace Knojector\SteamAuthenticationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author knojector <dev@knojector.xyz>
 */
#[\Attribute]
class MatchesLoginCallbackRoute extends Constraint
{
    public string $message = 'The parameter "openid_return_to" with value "{{ url }}" does not match original callback url "{{ expected }}".';
}