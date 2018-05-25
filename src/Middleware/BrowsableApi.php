<?php

namespace Steve\LaravelBrowsableApi\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response;

class BrowsableApi
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (strpos($request->headers->get('Accept'), 'text/html') === false) {
            return $response;
        }

        $prettify = config('browsable-api.prettify');
        if ($prettify) {
            $response->setContent(is_callable($prettify) ? $prettify($response) : $this->prettify($response));
        }

        $linkify = config('browsable-api.linkify');
        if ($linkify) {
            $response->setContent(is_callable($linkify) ? $linkify($response) : $this->linkify($response));
        }

        $response->setContent(view('browsable-api::api', ['request' => $request, 'response' => $response]));

        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }

    protected function prettify(Response $response)
    {
        if ($response->headers->get('Content-Type') == 'application/json') {
            return json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }
        return $response->getContent();
    }

    protected function linkify(Response $response)
    {
        return preg_replace_callback('#https?://[^"]+#', function ($matches) {
            return "<a href=\"{$matches[0]}\">{$matches[0]}</a>";
        }, $response->getContent());
    }
}
