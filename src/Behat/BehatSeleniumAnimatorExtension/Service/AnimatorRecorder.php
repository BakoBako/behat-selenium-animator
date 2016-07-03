<?php

namespace Bako\Behat\BehatSeleniumAnimatorExtension\Service;

use GifCreator\GifCreator;

class AnimatorRecorder
{
    /**
     * @var array
     */
    private $screenShots;
    
    /**
     * @var mixed
     */
    private $animator;
    
    public function __construct()
    {
        
    }
    
    public function addScreenShot($screenShot)
    {
        $this->screenShots[] = $screenShot;
    }    
    
    public function buildAnimator($outputDirectory)
    {
        $fileName = $this->generateFileName() . '.' . $this->getAnimatorExtension();
        
        $this->generateAnimator();
        $this->saveAnimator($outputDirectory, $fileName);
    }   
    
    private function generateAnimator()
    {
        $images = $this->prepareImages();
        
        $duration = [];
        
        for ($i = 0; $i < count($images); $i++) {
            $duration[] = 50;
        }
        
        $giftCreator = new GifCreator();
        $giftCreator->create($images, $duration);
        
        $this->animator = $giftCreator->getGif();
    }    
    
    private function prepareImages()
    {
        $images = [];
        
        foreach ($this->screenShots as $screenshoot) {
            $images[] = imagecreatefromstring($screenshoot);
        }
        
        return $images;
    }    
    
    private function saveAnimator($outputDirectory, $fileName)
    {
        if( !file_exists( $outputDirectory ) )
            mkdir ($outputDirectory);
        
        file_put_contents($outputDirectory . '/' . $fileName, $this->animator);        
    }    
    
    private function getAnimatorExtension()
    {
        return 'gif';
    }    
    
    private function generateFileName()
    {
        return sprintf(
            '%s_%s.%s',
            date('Ymd') . '-' . date('His'),
            uniqid('', true),
            uniqid('', true)
        );        
    }
}