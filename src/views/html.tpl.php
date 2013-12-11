<?php
/**
 * @todo better way to handle html lang and NgApp
 */
$ngApp = isset($ngApp) ? ($ngApp === true ? 'ng-app' : 'ng-app="'.$ngApp.'"') : '';
$lang = Lang::getLocale() ?: 'en';
?>
@section('doctype')
<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="<% $lang %>" dir="ltr" <% $this->ngApp %><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="<% $lang %>" dir="ltr" <% $this->ngApp %><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="<% $lang %>" dir="ltr" <% $this->ngApp %><![endif]-->
<!--[if IE 8]><html class="ie8" lang="<% $lang %>" dir="ltr" <% $this->ngApp %>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="<% $lang %>" dir="ltr" <% $this->ngApp %>><!--<![endif]-->
@show
<head>
    @section('head')
        <meta charset="UTF-8">
        <title><? $this->head['title'] ?></title>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    @show
</head>
@section('body')
<body <% isset($body, $body['attributes']) ? HTML::attributes($body['attributes']) : '' %>>
    @section('content')
        @yield('content')
    @show


    @section('js')
        @yield('js')
    @show

</body>
@show
</html>
@section('appendHtml')
<!-- Made with Arx @yield('arxBenchmark') -->
@show