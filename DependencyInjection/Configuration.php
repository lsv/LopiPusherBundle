<?php

namespace Lopi\Bundle\PusherBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * PusherBundle configuration structure.
 *
 * @author Pierre-Louis LAUNAY <laupi.frpar@gmail.com>
 */
class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('lopi_pusher', 'array');

        $rootNode
            ->validate()
                ->ifTrue(
                    function($data) {
                        return (empty($data['app_id'])
                            || empty($data['key'])
                            || empty($data['secret'])
                        );
                    }
                )
                ->thenInvalid('app_id, key and secret needs to be set.')
            ->end()
            ->children()
                ->scalarNode('app_id')->end()
                ->scalarNode('key')->end()
                ->scalarNode('secret')->end()
                ->scalarNode('cluster')->defaultValue('us-east-1')->end()
                ->booleanNode('debug')->defaultValue(false)->end()
                ->booleanNode('encrypted')->defaultTrue()->end()
                ->integerNode('timeout')->defaultValue(30)->end()
                ->scalarNode('auth_service_id')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}
