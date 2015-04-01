@extends('arx::layouts.bootstrap')

@section('body')
<body class="page-big-picture">

    <div class="navbar navbar-inverse navbar-fixed-bottom" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= $this->project['link'] ?: Lang::get('project.link') ?>"><?= $this->project['name'] ?: Lang::get('project.name') ?></a>
            </div>
            <div class="collapse navbar-collapse">
                @section('nav')
                <?php
                echo  \Arx\BootstrapHelper::nav(
                    $nav,
                    array('parent@' => array('class' => 'nav navbar-nav')));
                ?>
                @show
            </div><!--/.nav-collapse -->
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">
                <h1>The Big Picture</h1>
                <p>Here's a spot for some awesome intro text. Check out the fixed nav at the bottom!</p>
                <p>Set the background image in the CSS, pair it with some cool fonts, and you will have a rockin' start to a cool portfolio.</p>
            </div>
        </div>
    </div>

    <div class="full" style="background-image: url('http://placehold.it/1920x1080');"></div>

</body>
@stop