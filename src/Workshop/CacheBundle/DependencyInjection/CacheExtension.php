<?php

namespace Workshop\CacheBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class CacheExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader_bundle_services = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader_bundle_services->load('services.yml');

        $loader_domain_services = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../../UserManager/Infrastructure/DependencyInjection/Symfony'));
        $loader_domain_services->load('services/cache.yml');
        $loader_domain_services->load('config/cache.yml');
    }
}
