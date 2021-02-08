<?php

namespace Knojector\SteamAuthenticationBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @author knojector <dev@knojector.xyz>
 *
 * @Annotation
 */
class MatchesLoginCallbackRoute extends Constraint
{
    /**
     * @var string
     */
    public $message = 'The parameter "openid_return_to" with value "{{ url }}" does not match original callback url "{{ expected }}".';
}