<?php

if(!isset($_formLogin)){
    $_formLogin = Array(
        'attributes' => array(
            'class' => 'form-signin',
            'method' => 'POST'
        )
    );
}

if(isset($formLogin)){
    $formLogin = array_merge($_formLogin, $formLogin);
} else {
    $formLogin = $_formLogin;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{ $this->headtitle ?: Config::get('project.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $this->meta['description'] ?: Config::get('project.description') }}">
    <meta name="author" content="{{ $this->meta['author'] ?: Config::get('project.author') }}">

    <!-- Fav and touch icons -->
    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">

    <style type="text/css">
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background: url('http://api.arx.io/get/background');
        }

        .form-signin {
            max-width: 300px;
            padding: 19px 29px 29px;
            margin: 0 auto 20px;
            background-color: #fff;
            border: 1px solid #e5e5e5;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
            box-shadow: 0 1px 2px rgba(0,0,0,.05);
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 10px;
        }
        .form-signin input[type="text"],
        .form-signin input[type="password"] {
            font-size: 16px;
            height: auto;
            margin-bottom: 15px;
            padding: 7px 9px;
        }

    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
</head>

<body>

<div class="container">
    <form <?= HTML::attributes($formLogin['attributes'])?>>
        <h2 class="form-signin-heading">Please sign in</h2>
        <input name="email" type="text" class="input-block-level" placeholder="Email address">
        <input name="password" type="password" class="input-block-level" placeholder="Password">
        <label class="checkbox">
            <input type="checkbox" value="true" name="remember"> Remember me
        </label>
        @section('buttons')
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
        @show
    </form>

</div> <!-- /container -->

<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

</body>
</html>