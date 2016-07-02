<?php

namespace Bako\Behat\BehatSeleniumVideoExtension\Listener;

use Behat\Behat\EventDispatcher\Event\AfterStepTested;
use Behat\Behat\EventDispatcher\Event\StepTested;
use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Bako\Behat\BehatSeleniumVideo\ServiceContainer\Config;
use Bako\Behat\BehatSeleniumVideo\Service\VideoRecorder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class BehatSeleniumVideoListener implements EventSubscriberInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var VideoRecorder
     */
    private $videoRecorder;

    /**
     * @param Config         $config
     * @param VideoRecorder  $videoRecorder
     */
    public function __construct(Config $config, VideoRecorder $videoRecorder)
    {
        $this->config = $config;
        $this->videoRecorder = $videoRecorder;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StepTested::AFTER => 'stepFinished',
            ScenarioTested::AFTER => 'scenarioFinished'
        ];
    }

    /**
     * @param AfterStepTested $event
     */
    public function stepFinished(AfterStepTested $event)
    {
        if ($this->config->isRecordingEnabled()) {
            dd($event->getStep()->getSession());
            $this->videoRecorder->addSnapshot($event->getStep()->getSession());
        }
    }

    /**
     * @return void
     */
    public function scenarioFinished()
    {
        if ($this->config->isRecordingEnabled()) {
            
        }
    }
}