<?php

namespace Knojector\SteamAuthenticationBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author knojector <dev@knojector.xyz>
 */
class KnojectorSteamAuthenticationBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}