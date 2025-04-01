<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    */

    'paths' => ['*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
    'middleware' => ['api'],  // Add this line to specify middleware
    'headers' => [], // Add this line for custom headers
    'scopes' => [], // Add this line for OAuth scopes
    'prefix' => 'api', // Add this line for API prefix
];
