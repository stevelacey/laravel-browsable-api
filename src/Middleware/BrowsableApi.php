<?php

namespace Steve\LaravelBrowsableApi\Middleware;

use Closure;
use Illuminate\Http\Response;

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

        $prettyJson = json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $prettyHtmlJson = preg_replace_callback('#https?://[^"]+#', function ($matches) {
            $url = $matches[0];
            $href = preg_replace('#{\w+}#', '1', $url);

            return "<a href=\"{$href}\">{$url}</a>";
        }, $prettyJson);

        $response->setContent($prettyHtmlJson);

        $response->setContent(view('browsable-api::api', [
            'request' => $request,
            'response' => $response,
            'statuses' => Response::$statusTexts,
        ]));

        $response->headers->set('Content-Type', 'text/html');

        return $response;
    }
}
