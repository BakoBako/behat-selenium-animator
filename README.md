# Behat Selenium Animator

This tools generate gif animation of every step in behat that is runned with selenium.

## Installation

composer require bako/behat-selenium-animator

Add to behat configiration extension:
    Bako\Behat\BehatSeleniumVideoExtension: ~ 
        output_directory: directory_path (default is /tmp/behatseleniumvideo/)
        enabled_always: true/false (not recommended)    

## Basic Usage

Add "--animator-record" option when running behat
