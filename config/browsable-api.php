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

    /*
    |--------------------------------------------------------------------------
    | Breadcrumbify responses
    |--------------------------------------------------------------------------
    |
    | This option controls whether browsable api will add hyperlinks into the
    | url segments of the request path
    |
    */
    'breadcrumbify' => true,

    /*
    |--------------------------------------------------------------------------
    | Linkify responses
    |--------------------------------------------------------------------------
    |
    | This option controls whether browsable api will convert urls in responses
    | into hyperlinks, pass a callable if you want to supply your own logic
    |
    */
    'linkify' => true,

    /*
    |--------------------------------------------------------------------------
    | Prettify responses
    |--------------------------------------------------------------------------
    |
    | This option controls whether browsable api will pretty print json
    | responses, pass a callable if you want to supply your own logic
    |
    */
    'prettify' => true,
];
