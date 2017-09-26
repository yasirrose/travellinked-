<?php



return [



    /*

    |--------------------------------------------------------------------------

    | Third Party Services

    |--------------------------------------------------------------------------

    |

    | This file is for storing the credentials for third party services such

    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane

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

    'facebook' => [
        'client_id' => '434481623567844',
        'client_secret' => 'a4a3588c999f01414c4534114a217014',
        'redirect' => 'http://travellinked.com/travellinked/callback',

    ],

    'stripe' => [

        'model' => App\User::class,

        'key' => env('STRIPE_KEY'),

        'secret' => env('STRIPE_SECRET'),

    ],



];

