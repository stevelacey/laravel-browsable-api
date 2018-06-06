# Laravel Browsable API

[![Packagist License](https://poser.pugx.org/stevelacey/laravel-browsable-api/license.png)](http://choosealicense.com/licenses/mit/)
[![Latest Stable Version](https://poser.pugx.org/stevelacey/laravel-browsable-api/version.png)](https://packagist.org/packages/stevelacey/laravel-browsable-api)
[![Total Downloads](https://poser.pugx.org/stevelacey/laravel-browsable-api/d/total.png)](https://packagist.org/packages/stevelacey/laravel-browsable-api)

Laravel Browsable API is a package for generating human-friendly HTML output
for each resource when the HTML format is requested, heavily based on
[Django REST Framework's Browsable API](http://www.django-rest-framework.org/topics/browsable-api/)

![Screenshot](https://user-images.githubusercontent.com/289531/40294880-ed9e43c6-5d09-11e8-840c-a4d10d895a87.png)

The package prepends a middleware to the `api` router group that wraps responses
with a basic Bootstrap 4 based HTML template, and linkifies any URLs found

## Installation

```sh
composer require stevelacey/laravel-browsable-api
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
Steve\LaravelBrowsableApi\ServiceProvider::class,
```

Copy the package config and view into your project with the publish command:

```sh
php artisan vendor:publish --provider="Steve\LaravelBrowsableApi\ServiceProvider"
```
