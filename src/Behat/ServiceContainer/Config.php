<?php

namespace Bako\Behat\BehatSeleniumVideo\ServiceContainer;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class Config
{
    const CONFIG_KEY_ENABLED_ALWAYS = 'enabled_always';
    const CONFIG_KEY_OUTPUT_DIRECTORY = 'output_directory';

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    private $outputDirectory;

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    public function __construct(ContainerBuilder $container, $config)
    {
        $this->container = $container;
        $this->enabled = $config[self::CONFIG_KEY_ENABLED_ALWAYS];
        $this->outputDirectory = $config[self::CONFIG_KEY_OUTPUT_DIRECTORY];
    }

    /**
     * Activate the extension
     * 
     * @return void
     */
    public function enableRecording()
    {
        $this->enabled = true;
    }

    /**
     * @return boolean
     */
    public function isRecordingEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getOutputDirectory()
    {
        return $this->outputDirectory;
    }
}