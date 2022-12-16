<?php

declare(strict_types=1);

/*
 * This file is part of the package.
 *
 * (c) Nikolay Nikolaev <evrinoma@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Evrinoma\LinkBundle\DependencyInjection;

use Evrinoma\LinkBundle\EvrinomaLinkBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(EvrinomaLinkBundle::BUNDLE);
        $rootNode = $treeBuilder->getRootNode();
        $supportedDrivers = ['orm'];

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
            ->scalarNode('db_driver')
            ->validate()
            ->ifNotInArray($supportedDrivers)
            ->thenInvalid('The driver %s is not supported. Please choose one of '.json_encode($supportedDrivers))
            ->end()
            ->cannotBeOverwritten()
            ->defaultValue('orm')
            ->end()
            ->scalarNode('factory')->cannotBeEmpty()->defaultValue(EvrinomaLinkExtension::ENTITY_FACTORY_LINK)->end()
            ->scalarNode('entity')->cannotBeEmpty()->defaultValue(EvrinomaLinkExtension::ENTITY_BASE_LINK)->end()
            ->scalarNode('constraints')->defaultTrue()->info('This option is used to enable/disable basic link constraints')->end()
            ->scalarNode('dto')->cannotBeEmpty()->defaultValue(EvrinomaLinkExtension::DTO_BASE_LINK)->info('This option is used to dto class override')->end()
            ->arrayNode('decorates')->addDefaultsIfNotSet()->children()
            ->scalarNode('command')->defaultNull()->info('This option is used to command link decoration')->end()
            ->scalarNode('query')->defaultNull()->info('This option is used to query link decoration')->end()
            ->end()->end()
            ->arrayNode('services')->addDefaultsIfNotSet()->children()
            ->scalarNode('pre_validator')->defaultNull()->info('This option is used to pre_validator overriding')->end()
            ->scalarNode('handler')->cannotBeEmpty()->defaultValue(EvrinomaLinkExtension::HANDLER)->info('This option is used to handler override')->end()
            ->end()->end()
            ->end();

        return $treeBuilder;
    }
}
