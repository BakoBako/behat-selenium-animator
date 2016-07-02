<?php

namespace Bako\Behat\BehatSeleniumVideo\ServiceContainer;

use Behat\Testwork\ServiceContainer\Extension;
use Behat\Testwork\ServiceContainer\ExtensionManager;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * This class is the entry point of the step time logger extension
 *
 * @license http://opensource.org/licenses/MIT The MIT License
 */
class BehatSeleniumVideoExtension implements Extension
{
    const CONFIG_KEY = 'behatseleniumvideo';

     /**
     * {@inheritdoc}
     */
    public function getConfigKey()
    {
        return self::CONFIG_KEY;
    }

    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // nothing to do here
    }

    /**
     * {@inheritdoc}
     */
    public function initialize(ExtensionManager $extensionManager)
    {
        // nothing to do here
    }

    /**
     * {@inheritdoc}
     */
    public function configure(ArrayNodeDefinition $builder)
    {
        $builder
            ->children()
                ->booleanNode('enabled_always')
                    ->defaultFalse()
                ->end()
                ->scalarNode('output_directory')
                    ->defaultValue(sys_get_temp_dir() . DIRECTORY_SEPARATOR . self::CONFIG_KEY)
                ->end()
            ->end();
    }

    /**
     * {@inheritdoc}
     */
    public function load(ContainerBuilder $container, array $config)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/config'));
        $loader->load('services.xml');

        $extensionConfig = new Config($container, $config);
        $container->set('bako.behat_selenium_video_extension.config', $extensionConfig);
    }
}