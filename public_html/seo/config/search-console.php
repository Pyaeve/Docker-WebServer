<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication
    |--------------------------------------------------------------------------
    | Google offers access via OAuth client IDs or service accounts.
    | For more information see: https://developers.google.com/identity/protocols/OAuth2
    |
    | Supported: "oauth", "oauth_json", "service_account",
    */

    'auth_type' => env('GOOGLE_AUTH_TYPE', 'oauth'),

    /*
    |--------------------------------------------------------------------------
    | Application Credentials
    |--------------------------------------------------------------------------
    |
    | https://developers.google.com/api-client-library/php/auth/service-accounts#creatinganaccount
    */

    'connections' => [

        'oauth' => [
            'client_id' => '122366732472-tlte468luv52kqlqer2dl2kiagl0hpdi.apps.googleusercontent.com',
            'client_secret' =>'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',
        ],

        'oauth_json' => [
            'auth_config' => storage_path('google-credencials/deseo-367907-9be8a3009b39.json'),
        ],

        'service_account' => [
            'application_credentials' => env('GOOGLE_APPLICATION_CREDENTIALS'),
        ],

    ],

    /*
     |--------------------------------------------------------------------------
     | Cache Settings
     |--------------------------------------------------------------------------
     | Here you may configure the "store" that the underlying Google_Client will
     | use to store it's data.  You may also add extra parameters that will
     | be passed on setCacheConfig (see docs for google-api-php-client).
     |
     | Optional parameters: "lifetime", "prefix"
     */

    'cache' => [
        'store' => 'file',
    ],

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */

    'application_name' => env('SEARCH_CONSOLE_APPLICATION_NAME', 'GSC Agent'),
];
