<?php

namespace SteveLacey\LaravelBrowsableApi\Tests;

use Illuminate\Support\Facades\View;
use SteveLacey\LaravelBrowsableApi\Middleware\BrowsableApi;
use SteveLacey\LaravelBrowsableApi\ServiceProvider;

test('it merges the default config', function () {
    expect(config('browsable-api.name'))->toBe('Laravel API');
    expect(config('browsable-api.api_url'))->toBe('/api');
    expect(config('browsable-api.linkify'))->toBeTrue();
    expect(config('browsable-api.prettify'))->toBeTrue();
    expect(config('browsable-api.breadcrumbify'))->toBeTrue();
});

test('it prepends the middleware to the api group', function () {
    $router = $this->app->make('router');

    expect($router->getMiddlewareGroups()['api'])->toBe([BrowsableApi::class]);
});

test('it registers the package views', function () {
    expect(View::exists('browsable-api::api'))->toBeTrue();
});

test('it registers publishable config and views', function () {
    $packageRoot = dirname(__DIR__, 2);

    $paths = ServiceProvider::pathsToPublish(ServiceProvider::class, 'config');
    expect(array_combine(array_map('realpath', array_keys($paths)), $paths))->toBe(
        [realpath($packageRoot.'/config/browsable-api.php') => config_path('browsable-api.php')],
    );

    $paths = ServiceProvider::pathsToPublish(ServiceProvider::class, 'views');
    expect(array_combine(array_map('realpath', array_keys($paths)), $paths))->toBe(
        [realpath($packageRoot.'/resources/views/api.blade.php') => resource_path('views/vendor/browsable-api/api.blade.php')],
    );
});

test('it provides the browsable api service', function () {
    $provider = new ServiceProvider($this->app);

    expect($provider->provides())->toBe(['browsable-api']);
});
