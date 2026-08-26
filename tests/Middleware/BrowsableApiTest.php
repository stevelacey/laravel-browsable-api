<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use SteveLacey\LaravelBrowsableApi\Middleware\BrowsableApi;

function browsableApiRequest(?string $accept = 'text/html'): Request
{
    $request = Request::create('/api/users/1');

    if ($accept !== null) {
        $request->headers->set('Accept', $accept);
    } else {
        $request->headers->remove('Accept');
    }

    return $request;
}

function browsableApiNext(Response $response): Closure
{
    return fn () => $response;
}

test('it passes through when disabled via config', function () {
    config(['browsable-api.enabled' => false]);

    $response = new Response('{"ok":true}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->headers->get('Content-Type'))->toBe('application/json');
    expect($result->getContent())->toBe('{"ok":true}');
});

test('it passes through when debug is false and enabled is not set', function () {
    config(['app.debug' => false]);

    $response = new Response('{"ok":true}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->headers->get('Content-Type'))->toBe('application/json');
});

test('enabled true overrides debug false', function () {
    config(['app.debug' => false, 'browsable-api.enabled' => true]);

    $response = new Response('{"ok":true}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->headers->get('Content-Type'))->toBe('text/html');
});

test('it passes through when accept header does not request html', function () {
    config(['app.debug' => true]);

    $response = new Response('{"ok":true}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest('application/json'), browsableApiNext($response));

    expect($result->headers->get('Content-Type'))->toBe('application/json');
});

test('it passes through when accept header is missing', function () {
    config(['app.debug' => true]);

    $response = new Response('{"ok":true}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(null), browsableApiNext($response));

    expect($result->headers->get('Content-Type'))->toBe('application/json');
});

test('it passes through a response that is already html', function () {
    config(['app.debug' => true]);

    $response = new Response('<p>hi</p>', 200, ['Content-Type' => 'text/html; charset=UTF-8']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toBe('<p>hi</p>');
});

test('it passes through a response with no content type header', function () {
    config(['app.debug' => true]);

    $response = new Response('<p>hi</p>');

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toBe('<p>hi</p>');
});

test('it wraps a json response in the browsable html view', function () {
    config(['app.debug' => true]);

    $response = new Response('{"name":"Ada"}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->headers->get('Content-Type'))->toBe('text/html');
    expect($result->getContent())
        ->toContain('HTTP 200 OK')
        ->toContain('/api/users/1');
});

test('prettify pretty prints json content by default', function () {
    config(['app.debug' => true]);

    $response = new Response('{"name":"Ada"}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toContain('"name": "Ada"');
});

test('prettify leaves non json content type untouched', function () {
    config(['app.debug' => true]);

    $response = new Response('plain body', 200, ['Content-Type' => 'text/plain']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toContain('plain body');
});

test('prettify can be disabled', function () {
    config(['app.debug' => true, 'browsable-api.prettify' => false]);

    $response = new Response('{"name":"Ada"}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toContain('{"name":"Ada"}');
});

test('prettify accepts a callable', function () {
    config([
        'app.debug' => true,
        'browsable-api.prettify' => fn ($response) => 'PRETTIFIED:'.$response->getContent(),
    ]);

    $response = new Response('{"name":"Ada"}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toContain('PRETTIFIED:{"name":"Ada"}');
});

test('linkify wraps urls in anchor tags by default', function () {
    config(['app.debug' => true]);

    $response = new Response('{"url":"https://example.com/path"}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toContain('<a href="https://example.com/path">https://example.com/path</a>');
});

test('linkify can be disabled', function () {
    config(['app.debug' => true, 'browsable-api.linkify' => false]);

    $response = new Response('{"url":"https://example.com/path"}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->not->toContain('<a href="https://example.com/path">');
});

test('linkify accepts a callable', function () {
    config([
        'app.debug' => true,
        'browsable-api.prettify' => false,
        'browsable-api.linkify' => fn ($response) => 'LINKIFIED:'.$response->getContent(),
    ]);

    $response = new Response('{"name":"Ada"}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())->toContain('LINKIFIED:{"name":"Ada"}');
});

test('breadcrumbify links each path segment', function () {
    config(['app.debug' => true, 'browsable-api.breadcrumbify' => true]);

    $response = new Response('{}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())
        ->toContain('<a href="/api">api</a>')
        ->toContain('<a href="/api/users">users</a>');
});

test('breadcrumbify can be disabled', function () {
    config(['app.debug' => true, 'browsable-api.breadcrumbify' => false]);

    $response = new Response('{}', 200, ['Content-Type' => 'application/json']);

    $result = (new BrowsableApi)->handle(browsableApiRequest(), browsableApiNext($response));

    expect($result->getContent())
        ->not->toContain('<a href="/api">')
        ->toContain('/api/users/1');
});
