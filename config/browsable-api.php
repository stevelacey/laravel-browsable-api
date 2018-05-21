<?php

return [
    /*
    |--------------------------------------------------------------------------
    | API Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your API. This value is used when browsable API
    | needs to place the API's name in title tags and headings
    |
    */
    'name' => env('API_NAME', env('APP_NAME', 'Laravel') . ' API'),

    /*
    |--------------------------------------------------------------------------
    | API URL
    |--------------------------------------------------------------------------
    |
    | This value is the root of your API. This value is used when browsable API
    | needs to link to the API root in the base template
    |
    */
    'api_url' => '/api',
];
