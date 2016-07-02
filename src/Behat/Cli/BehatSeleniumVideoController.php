<?php

namespace Bako\Behat\BehatSeleniumVideo\Cli;

use Behat\Testwork\Cli\Controller;
use  Bako\Behat\BehatSeleniumVideo\ServiceContainer\Config;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class BehatSeleniumVideoController implements Controller
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;    
    }

    /**
     * Configures command to be executable by the controller.
     *
     * @param SymfonyCommand $command
     */
    public function configure(SymfonyCommand $command)
    {
        $command->addOption('--video-record', null, InputOption::VALUE_NONE, 'Record steps video');
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('video-record')) {
            $this->config->enableRecording();
        }
    }
}