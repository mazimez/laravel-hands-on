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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('APP_ENV'),
    ],

    'two_factor' => [
        'api_url' => 'https://2factor.in/API/V1/',
        'api_key' => env('TWO_FACTOR_API_KEY'),
        'template_name' => env('TWO_FACTOR_TEMPLATE_NAME'),
        'is_otp_live' => env('IS_OTP_LIVE', 0)
    ],
    'firebase' => [
        'api_key' => env('API_KEY'),
        'auth_domain' => env('AUTH_DOMAIN'),
        'project_id' => env('PROJECT_ID'),
        'storage_bucket' => env('STORAGE_BUCKET'),
        'sender_id' => env('FCM_SENDER_ID'),
        'app_id' => env('APP_ID'),
        'measurement_id' => env('MEASUREMENT_ID'),
    ],
];
