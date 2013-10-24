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
@section('body')
<body {{ isset($body, $body['attributes']) ? HTML::attributes($body['attributes']) : '' }}>
    @yield('body.content')
    @yield('js')
</body>
@show
</html>
@section('appendHtml')
<!-- Made with Arx @yield('arxBenchmark') -->
@show