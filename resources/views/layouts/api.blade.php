<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="google" content="notranslate">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title>@yield('title', config('browsable-api.name'))</title>

        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">

        <style>.prettyprint a span { color: inherit }</style>
    </head>

    <body>
        <header>
            @if(View::hasSection('header'))
                <div class="collapse bg-dark" id="navbarHeader">
                    <div class="container">
                        @yield('header')
                    </div>
                </div>
            @endif
            <div class="navbar navbar-dark bg-dark box-shadow">
                <div class="container d-flex justify-content-between">
                    <a href="{{ config('browsable-api.api_url') }}" class="navbar-brand d-flex align-items-center">
                        @yield('logo')
                        <strong>@yield('title', config('browsable-api.name'))</strong>
                    </a>

                    @if(View::hasSection('header'))
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                    @endif
                </div>
            </div>
        </header>

        <main role="main">
            <div class="py-5 bg-light">
                <div class="container">
                    <div class="request-info">
                        <pre class="border bg-white p-3 rounded"><b>{{ $request->getMethod() }}</b> @if(config('browsable-api.breadcrumbify'))
@foreach([explode('/', trim($request->getPathInfo(), '/'))] as $segments)
@foreach($segments as $i => $segment)/<a href="/{{ implode('/', array_slice($segments, 0, $i + 1)) }}">{{ $segment }}</a>@endforeach
@endforeach</pre>
@else
{{ $request->getRequestUri() }}</pre>
@endif
                    </div>

                    <div class="response-info">
                        <pre class="border bg-white p-3 rounded prettyprint"><code><span class="meta nocode"><b>HTTP {{ $response->status() }} {{ $response::$statusTexts[$response->status()] }}</b>
@foreach($response->headers as $key => $values)
@foreach($values as $value)
<b>{{ ucwords($key, '-') }}:</b> <span class="lit">{{ $value }}</span>
@endforeach
@endforeach

</span>{!! $response->getContent() !!}</code></pre>
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-5 text-muted">
            <div class="container clearfix">
                <p class="float-right">
                    <a href="#">Back to top</a>
                </p>
                @yield('footer')
            </div>
        </footer>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script aysnc src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script async src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
    </body>
</html>
