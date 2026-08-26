# Laravel Browsable API

[![Packagist Version](https://img.shields.io/packagist/v/stevelacey/laravel-browsable-api?style=flat-square)](https://packagist.org/packages/stevelacey/laravel-browsable-api)
[![CI](https://img.shields.io/github/actions/workflow/status/stevelacey/laravel-browsable-api/ci.yml?style=flat-square)](https://github.com/stevelacey/laravel-browsable-api/actions/workflows/ci.yml?query=branch:main)
[![Coverage](https://img.shields.io/codecov/c/github/stevelacey/laravel-browsable-api?style=flat-square)](https://codecov.io/gh/stevelacey/laravel-browsable-api)
[![Downloads](https://img.shields.io/packagist/dt/stevelacey/laravel-browsable-api?style=flat-square)](https://packagist.org/packages/stevelacey/laravel-browsable-api)
[![License: MIT](https://img.shields.io/github/license/stevelacey/laravel-browsable-api?style=flat-square)](LICENSE.md)

Laravel Browsable API is a package for serving human-friendly HTML output when using a browser, based on [Django REST Framework's Browsable API](http://www.django-rest-framework.org/topics/browsable-api/)

![Screenshot](https://user-images.githubusercontent.com/289531/40294880-ed9e43c6-5d09-11e8-840c-a4d10d895a87.png)

The package prepends a middleware to the `api` router group that wraps responses with a basic Bootstrap 4 based HTML template, and linkifies any URLs found

## Installation

```sh
composer require stevelacey/laravel-browsable-api
```

Laravel 5.5 uses Package Auto-Discovery, so doesn't require you to manually add the ServiceProvider

If you don't use auto-discovery, add the ServiceProvider to the providers array in config/app.php

```php
SteveLacey\LaravelBrowsableApi\ServiceProvider::class,
```

Copy the package config and view into your project with the publish command:

```sh
php artisan vendor:publish --provider="SteveLacey\LaravelBrowsableApi\ServiceProvider"
```
