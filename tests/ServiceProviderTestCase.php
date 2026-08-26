<?php

namespace SteveLacey\LaravelBrowsableApi\Tests;

class ServiceProviderTestCase extends TestCase
{
    protected function defineEnvironment($app)
    {
        $app->make('router')->middlewareGroup('api', []);
    }
}
