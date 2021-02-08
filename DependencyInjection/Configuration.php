<?php

namespace Knojector\SteamAuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author knojector <dev@knojector.xyz>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('knojector_steam_authentication');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('login_failure_redirect')->isRequired()->end()
                ->scalarNode('login_success_redirect')->isRequired()->end()
            ->end()
        ;

        return $treeBuilder;
    }
}