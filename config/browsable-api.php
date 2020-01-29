<?php

return [

    /*
     |--------------------------------------------------------------------------
     | Browsable API Settings
     |--------------------------------------------------------------------------
     |
     | Browsable API is enabled by default when debug is set to true in app.php.
     | You can override the value by setting enable to true or false instead of null.
     |
     */

    'enabled' => env('BROWSABLE_API_ENABLED', null),

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
