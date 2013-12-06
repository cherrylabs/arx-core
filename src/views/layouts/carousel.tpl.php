@extends('arx::html')

@section('head')
<meta http-equiv="Content-Type" content="; charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?= $this->metatitle ?></title>
<?php
if (!isset($aStylesheets)) {
    echo Asset::css(array(
       '//netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'
    ));
}
?>
@stop

@section('body.content')

@section('navbar')
<div class="navbar-wrapper">
    <div class="container">

        <div class="navbar navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <img src="<?= Arx\classes\Dummy::image('100x50') ?>" alt=""/>
                </div>
                <div class="navbar-collapse collapse pull-right">
                    <?php echo \Arx\helpers\Bootstrap::nav(Lang::get('arx::example.menu')) ?>
                </div>
            </div>
        </div>

    </div>
</div>
@show


@section('carousel')
<div id="myCarousel" class="carousel slide">
    <!-- Indicators -->
    <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            <img src="<?= \Arx\classes\Dummy::image('1280x720', 'e5e5e5') ?>>" data-src="" alt="">

            <div class="container">
                <div class="carousel-caption">
                    <h1><span class="text-muted">Example (see arx/views/layouts/carousel.blade.php)</h1>

                    <p><?= \Arx\classes\Dummy::text(array('amount' => '1')) ?></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?= \Arx\classes\Dummy::image('1280x720', 'e5e5e5') ?>>" data-src="" alt="">

            <div class="container">
                <div class="carousel-caption">
                    <h1><span class="text-muted">Example (see arx/views/layouts/carousel.blade.php)</h1>

                    <p><?= \Arx\classes\Dummy::text(array('amount' => '1')) ?></p>
                </div>
            </div>
        </div>
        <div class="item">
            <img src="<?= \Arx\classes\Dummy::image('1280x720', 'e5e5e5') ?>>" data-src="" alt="">

            <div class="container">
                <div class="carousel-caption">
                    <h1><span class="text-muted">Example (see arx/views/layouts/carousel.blade.php)</h1>

                    <p><?= \Arx\classes\Dummy::text(array('amount' => '1')) ?></p>
                </div>
            </div>
        </div>
    </div>
    <a class="left carousel-control" href="#myCarousel" data-slide="prev"><span
            class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next"><span
            class="glyphicon glyphicon-chevron-right"></span></a>
</div>
<!-- /.carousel -->
@show

@section('content')
<div class="container marketing">

    <h1 class="headtitle"><?php echo Lang::get('arx::example.project.title') ?></h1>

    <hr class="featurette-divider">

    <!-- Featured -->
    <div class="row featurette">
        <div class="col-md-5">
            <img class="featurette-image img-responsive" src="<?= \Arx\classes\Dummy::image('400x300') ?>"
                 alt="Generic placeholder image">
        </div>
        <div class="col-md-7 text-middle">
            <h2 class="featurette-heading"><?= \Arx\classes\Dummy::title(60) ?><br/><span
                    class="text-muted"><?= \Arx\classes\Dummy::title(20) ?></span></h2>

            <p class="lead">
                <?= \Arx\classes\Dummy::title(60) ?>
            </p>
        </div>
    </div>

</div>
<!-- /.container -->
@show

@section('footer')
<div class="container">
    <hr/>
    <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>

        <p>&copy; 2013 Cherrypulp, LLC. &middot; <a href="/privacy">Privacy</a> &middot; <a href="#">Code licensed under
                the The MIT License. Documentation licensed under <a href="http://creativecommons.org/licenses/by/3.0/">CC
                    BY 3.0</a></p>
    </footer>
    <!--/footer-->
</div>
@show
@stop