<?php

namespace Bako\Behat\BehatSeleniumAnimatorExtension\Listener;

use Behat\Behat\EventDispatcher\Event\BeforeStepTested;
use Behat\Behat\EventDispatcher\Event\AfterStepTested;
use Behat\Behat\EventDispatcher\Event\StepTested;
use Behat\Behat\EventDispatcher\Event\ScenarioTested;
use Behat\Behat\EventDispatcher\Event\AfterScenarioTested;
use Bako\Behat\BehatSeleniumAnimatorExtension\ServiceContainer\Config;
use Bako\Behat\BehatSeleniumAnimatorExtension\Service\AnimatorRecorder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Behat\Mink\Driver\Selenium2Driver;
use Behat\Mink\Mink;
use WebDriver\Exception\UnexpectedAlertOpen;
use WebDriver\Exception\NoAlertOpenError;

final class BehatSeleniumAnimatorListener implements EventSubscriberInterface
{
    /**
     * @var Mink
     */    
    private $mink;
    
    /**
     * @var Config
     */
    private $config;

    /**
     * @var AnimatorRecorder
     */
    private $animatorRecorder;

    /**
     * @var boolean
     */
    private $canRecord = false;

    /**
     * @param Config         $config
     * @param AnimatorRecorder  $animatorRecorder
     */
    public function __construct(Mink $mink, Config $config, AnimatorRecorder $animatorRecorder)
    {
        $this->mink = $mink;
        $this->config = $config;
        $this->animatorRecorder = $animatorRecorder;                
    }

    private function checkRecorder()
    {
        $driver = $this->mink->getSession()->getDriver();
        
        if (! ($driver instanceof Selenium2Driver)) {
            $this->canRecord = false;
            return false;
        }        
        
        $this->canRecord = true;
        return true;
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            StepTested::BEFORE => 'stepStarted',
            StepTested::AFTER => 'stepFinished',
            ScenarioTested::BEFORE => 'scenarioStarted',
            ScenarioTested::AFTER => 'scenarioFinished'
        ];
    }

    private function canTakeScreenShot()
    {                
        return ($this->config->isRecordingEnabled() && $this->canRecord);
    }

    private function takeScreenShot()
    {
        if ($this->canTakeScreenShot()) {            
            try{
                $session = $this->mink->getSession();
                $driver = $session->getDriver();                
                
                $this->animatorRecorder->addScreenShot($driver->getScreenshot());    
            } catch (UnexpectedAlertOpen $ex) {
                try {
                    $driver->getWebDriverSession()->accept_alert();
                } catch( NoAlertOpenError $exce ) {
                    
                }
            }            
        }
        
        return true;
    }
    
    /**
     * @param BeforeStepTested $event
     */
    public function stepStarted(BeforeStepTested $event)
    {
        $this->takeScreenShot();
    }

    /**
     * @param AfterStepTested $event
     */
    public function stepFinished(AfterStepTested $event)
    {
        $this->takeScreenShot();
    }

    /**
     * @return void
     */
    public function scenarioStarted()
    {
        $this->checkRecorder();        
        $this->takeScreenShot();
    }

    /**
     * @param AfterScenarioTested $event
     * 
     * @return void
     */
    public function scenarioFinished(AfterScenarioTested $event)
    {
        $this->takeScreenShot();
        
        if ($this->canRecord && $this->config->isRecordingEnabled()) {
            $this->animatorRecorder->buildAnimator(
                $this->config->getOutputDirectory(),
                $event->getScenario()->getTitle()
            );
        }
    }
}