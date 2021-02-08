<?php

namespace Knojector\SteamAuthenticationBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author knojector <dev@knojector.xyz>
 */
class KnojectorSteamAuthenticationExtension extends Extension
{
    /**
     * @inheritDoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(dirname(__DIR__).'/Resources/config'));
        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('knojector.steam_authentication.login_failure_redirect', $config['login_failure_redirect']);
        $container->setParameter('knojector.steam_authentication.login_success_redirect', $config['login_success_redirect']);
    }
}