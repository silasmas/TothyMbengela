<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    | Paiement en ligne (Mobile Money + carte) — voir docs/integration-paiement-flexpay/
    */
    'flexpay' => [
        'enabled' => (bool) env('FLEXPAY_API_TOKEN'),
        'token' => env('FLEXPAY_API_TOKEN'),
        'merchant' => env('FLEXPAY_MARCHAND'),
        'gateway_card' => env('FLEXPAY_GATEWAY_CARD', 'https://cardpayment.flexpay.cd/v1/payment'),
        'gateway_mobile' => env('FLEXPAY_GATEWAY_MOBILE', 'https://backend.flexpay.cd/api/rest/v1/payment'),
    ],

];
