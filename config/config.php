<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'endpoint' => env('COREBANK_ENDPOINT', 'http://codeinvader.com/api'),
    'app_id' => env('COREBANK_APP_ID'),
    'secret' => env('COREBANK_APP_SECRET', 'hrOdYuexejEE8XQWFqIoZgIV0bSF5jFcdSH0GGPb'),

];
