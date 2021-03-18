<?php

declare(strict_types=1);

namespace MinVWS\PUZI\AuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('puzi_auth');

        $treeBuilder->getRootNode()
            ->children()
                ->booleanNode('strict_ca_check')->defaultValue(true)->end()
                ->arrayNode('allowed_types')->treatNullLike([])->scalarPrototype()->end()->end()
                ->arrayNode('allowed_roles')->treatNullLike([])->scalarPrototype()->end()->end()
            ->end();

        return $treeBuilder;
    }
}
