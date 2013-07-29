@section('doctype')
    <!DOCTYPE HTML>
    <html lang="en-GB">
@show
<head>
    @section('head')
        <meta charset="UTF-8">
        <title>@yield('title')</title>
    @show
</head>
<body <?php !isset($body, $body['attributes']) ?: HTML::attr($body['attributes']) ?>>
@yield('body')
@yield('js')
</body>
</html>
@section('appendHtml')
<!-- Made with Arx @yield('arxBenchmark') -->
@show