<?php

namespace ZipkinBundle\DependencyInjection;

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        if (Kernel::VERSION[0] === '5') {
            $treeBuilder = new TreeBuilder('zipkin');
            $rootNode = $treeBuilder->getRootNode();
        } else {
            $treeBuilder = new TreeBuilder();
            $rootNode = $treeBuilder->root('zipkin');
        }

        $rootNode
            ->children()
            ->booleanNode('noop')->defaultFalse()->end()
            ->scalarNode('service_name')->defaultNull()->end()
            ->arrayNode('sampler')->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('type')
            ->defaultValue('never')
            ->end()
            ->arrayNode('route')->addDefaultsIfNotSet()
            ->canBeDisabled()
            ->children()
            ->arrayNode('included_routes')
            ->prototype('scalar')->end()
            ->end()
            ->arrayNode('excluded_routes')
            ->prototype('scalar')->end()
            ->end()
            ->end()
            ->end()
            ->arrayNode('path')->addDefaultsIfNotSet()
            ->canBeDisabled()
            ->children()
            ->arrayNode('included_paths')->defaultValue([])
            ->prototype('scalar')->end()
            ->end()
            ->arrayNode('excluded_paths')->defaultValue([])
            ->prototype('scalar')->end()
            ->end()
            ->end()
            ->end()
            ->scalarNode('percentage')->defaultValue(0.1)->end()
            ->scalarNode('custom')->defaultValue('')->end()
            ->end()
            ->end()
            ->arrayNode('reporter')->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('type')->defaultValue('log')->end()
            ->scalarNode('metrics')->defaultValue(null)->end()
            ->arrayNode('http')->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('endpoint_url')->defaultValue('http://zipkin:9411/api/v2/spans')->end()
            ->scalarNode('timeout')->defaultValue(null)->end()
            ->end()
            ->end()
            ->end()
            ->end()
            ->end();

        return $treeBuilder;
    }
}
