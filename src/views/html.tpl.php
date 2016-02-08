<?php
$ngApp = $this->ngApp ? ($this->ngApp === true ? 'ng-app' : 'ng-app="'.$this->ngApp.'"') : '';
$lang = Lang::getLocale() ?: 'en';
?>
@section('doctype')
<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="<?php echo  $lang ?>" dir="ltr" <?php echo  $ngApp ?>><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="<?php echo  $lang ?>" dir="ltr" <?php echo  $ngApp ?>><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="<?php echo  $lang ?>" dir="ltr" <?php echo  $ngApp ?>><![endif]-->
<!--[if IE 8]><html class="ie8" lang="<?php echo  $lang ?>" dir="ltr" <?php echo  $ngApp ?>><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="<?php echo  $lang ?>" dir="ltr" <?php echo  $ngApp ?>><!--<![endif]-->
@show
<head>
    @section('head')
        <meta charset="UTF-8">
        <title>@yield('head_title')</title>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    @show
</head>
<body <?php echo  isset($body, $body['attributes']) ? HTML::attributes($body['attributes']) : '' ?>>
    @section('body')
        <?php #'The section layout define which layout to use : here is the most simple layout it will output just a $content' ?>
        @section('content')
            @yield('content')
        @show
    @show
    @section('js')
        @yield('js')
    @show
</body>
</html>
@section('appendHtml')
<!-- Made with Arx @yield('arxBenchmark') -->
@show
