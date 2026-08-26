<?php

namespace SteveLacey\LaravelBrowsableApi\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use SteveLacey\LaravelBrowsableApi\ServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }
}
