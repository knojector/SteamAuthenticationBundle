<?php

namespace Knojector\SteamAuthenticationBundle\DTO;

use Knojector\SteamAuthenticationBundle\Validator as SteamAssert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author knojector <dev@knojector.xyz>
 */
class SteamCallback
{
    #[Assert\NotBlank]
    #[Assert\EqualTo('http://specs.openid.net/auth/2.0')]
    public string $openid_ns;

    #[Assert\NotBlank]
    public string $openid_mode;

    #[Assert\NotBlank]
    #[Assert\EqualTo('https://steamcommunity.com/openid/login')]
    public string $openid_op_endpoint;

    #[Assert\NotBlank]
    #[Assert\Expression('this.openid_claimed_id === this.openid_identity')]
    public string $openid_claimed_id;

    #[Assert\NotBlank]
    public string $openid_identity;

    #[Assert\NotBlank]
    #[SteamAssert\MatchesLoginCallbackRoute]
    public string $openid_return_to;

    #[Assert\NotBlank]
    public string $openid_response_nonce;

    #[Assert\NotBlank]
    public string $openid_assoc_handle;

    #[Assert\NotBlank]
    public string $openid_signed;

    #[Assert\NotBlank]
    public $openid_sig;

    public function getCommunityId(): string
    {
        return str_replace('https://steamcommunity.com/openid/id/', '', $this->openid_identity);
    }

    public static function fromRequest(Request $request): self
    {
        $steamCallback = new self;
        $steamCallback->openid_ns = $request->get('openid_ns');
        $steamCallback->openid_mode = $request->get('openid_mode');
        $steamCallback->openid_op_endpoint = $request->get('openid_op_endpoint');
        $steamCallback->openid_claimed_id = $request->get('openid_claimed_id');
        $steamCallback->openid_identity = $request->get('openid_identity');
        $steamCallback->openid_return_to = $request->get('openid_return_to');
        $steamCallback->openid_response_nonce = $request->get('openid_response_nonce');
        $steamCallback->openid_assoc_handle = $request->get('openid_assoc_handle');
        $steamCallback->openid_signed = $request->get('openid_signed');
        $steamCallback->openid_sig = $request->get('openid_sig');

        return $steamCallback;
    }
}