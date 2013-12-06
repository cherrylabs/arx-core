<?php
/**
 * @todo better way to handle html lang
 */
$ngApp = isset($ngApp) ? ($ngApp === true ? 'ng-app' : 'ng-app="'.$ngApp.'"') : '';
$lang = Lang::getLocale() ?: 'en';

?>
@section('doctype')
<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="{{ $lang }}" dir="ltr" {{ $ngApp }}><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="{{ $lang }}" dir="ltr" {{ $ngApp }}><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="{{ $lang }}" dir="ltr" {{ $ngApp }}><![endif]-->
<!--[if IE 8]><html class="ie8" lang="{{ $lang }}" dir="ltr" {{ $ngApp }}><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="{{ $lang }}" dir="ltr" {{ $ngApp }}><!--<![endif]-->
@show
<head>
    @section('head')
        <meta charset="UTF-8">
        <title>@yield('headtitle')</title>
    @show
    <?php
    if ($this->ngApp) {
        echo '<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.0-rc.3/angular.min.js"></script>';
    }
    ?>
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