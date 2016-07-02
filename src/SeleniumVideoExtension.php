<?php

namespace Bako\Behat;

use Behat\Behat\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Behat\Behat\Context\ServiceContainer\ContextExtension;

class SeleniumVideoExtension implements ExtensionInterface
{     
    public function load(array $config, ContainerBuilder $container)
    {
        $definition = new Definition('Bako\Behat\Context\SeleniumVideoContext', [$app]);

        $definition->addTag(EventDispatcherExtension::SUBSCRIBER_TAG, ['priority' => 0]);
        $definition->addTag(ContextExtension::INITIALIZER_TAG, ['priority' => 0]);

        $container->setDefinition('laravel.initializer', $definition);        
    }
}
