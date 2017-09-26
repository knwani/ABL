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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => '126582094645959',
        'client_secret' => '7054b83d58d0a5c50d9ce67955cf8425',
        'redirect' => 'http://abeautifullifebykenny.com/callback/facebook',
    ],

    'twitter' => [
        'client_id' => 'vitbQPp9ywpktvYJoDoJmJe6F',
        'client_secret' => 'ZrFAmhAbog1gLVJ9dQERlnn6loTf7byBVkLsAhnwHfC2ltGgXg',
        'redirect' => 'http://abeautifullifebykenny.com/callback/twitter',
    ],

    'google' => [
        'client_id' => '1033057424522-0ogp1fbr61tf8kok9goumml3ro41g1s6.apps.googleusercontent.com',
        'client_secret' => 'zJg-9hJfXZXZ7GD4zo9HMjFM',
        'redirect' => 'http://abeautifullifebykenny.com/callback/google',
    ],

];
