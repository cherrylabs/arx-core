<?php
/**
 * @todo : get current language
 */
?>
@section('doctype')
<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="en" dir="ltr"><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="en" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="en" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="ie8" lang="en" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="en" dir="ltr"><!--<![endif]-->
@show
<head>
    @section('head')
        <meta charset="UTF-8">
        <title>@yield('headtitle')</title>
    @show
</head>
@section('body')
<body {{ isset($body, $body['attributes']) ? HTML::attributes($body['attributes']) : '' }}>
    @yield('body.content')
</body>
@show
@section('js')
@show
</html>
@section('appendHtml')
<!-- Made with Arx @yield('arxBenchmark') -->
@show