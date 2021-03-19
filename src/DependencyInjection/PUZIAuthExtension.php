<?php

declare(strict_types=1);

namespace MinVWS\PUZI\AuthBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

class PUZIAuthExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('puzi_auth.strict_ca_check', $config['strict_ca_check']);
        $container->setParameter('puzi_auth.allowed_types', $config['allowed_types']);
        $container->setParameter('puzi_auth.allowed_roles', $config['allowed_roles']);
    }
}
