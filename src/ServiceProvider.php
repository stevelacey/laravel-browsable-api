<?php

namespace Steve\LaravelBrowsableApi;

use Illuminate\Routing\Router;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/browsable-api.php', 'browsable-api');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $router->prependMiddlewareToGroup('api', Middleware\BrowsableApi::class);

        $this->publishes([__DIR__ . '/../config/browsable-api.php' => config_path('browsable-api.php')], 'config');
        $this->publishes([__DIR__ . '/../resources/views/api.blade.php' => resource_path('views/vendor/browsable-api/api.blade.php')], 'views');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'browsable-api');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['browsable-api'];
    }
}
