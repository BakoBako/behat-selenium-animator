# Laravel Email Tester

Laravel Email Tester is a tool that let you test laravel mail setup via artisan commands.

## Installation

composer require bako/laravel-mail-tester

Register service provider "Bako\Laravel\MailTester\MailTesterProvider"

## Basic Usage

php artisan mail:test email_address

Options:

    * "--subject" Set up email subject ( Default is "Test" ).
        php artisan mail:test email_address --subject=Subject

    * "--body" Set up email body ( Default is "Test" and will be discarded if view is setup ).
        php artisan mail:test email_address --body=Body

    * "--queue" Whether the send of email should be via queue.
        php artisan mail:test email_address --queue

    * "--view" Test email from view
        php artisan mail:test email_address --view=viewName