@extends('arx::html')

@section('head')
    <meta http-equiv="Content-Type" content="; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title>Carousel Template for Bootstrap</title>

    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
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
                            <img src="<?= Arx\classes\Dummy::image() ?>" alt="Arx webdevelopment kit"/>
                        </div>
                        <div class="navbar-collapse collapse pull-right">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="#">Home</a></li>
                                <li><a href="#about">Docs</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Repositories <b
                                            class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="#">Action</a></li>
                                        <li><a href="#">Another action</a></li>
                                        <li><a href="#">Something else here</a></li>
                                        <li class="divider"></li>
                                        <li class="dropdown-header">Nav header</li>
                                        <li><a href="#">Separated link</a></li>
                                        <li><a href="#">One more separated link</a></li>
                                    </ul>
                                </li>
                            </ul>
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
                    <img src="{{url('arx')}}img/bg-node.jpg" data-src="" alt="php web development kit">

                    <div class="container">
                        <div class="carousel-caption">
                            <h1><span class="text-muted">Discover the </span><br />next gen Web development toolkit</h1>
                            <p>Arx is a bunch of classes, controllers, models, views and assets<br />to develop 5.0 web app with elegance and rapidity</p>
                            <p><a class="btn btn-large btn-primary" href="<?= Lang::get('arx::example.link') ?>">Download the kit</a></p>
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

        <h1 class="headtitle">We would like to introduce Arx<sup>alpha</sup> Release</h1>

        <hr class="featurette-divider">

        <!-- Featured -->
        <div class="row featurette">
            <div class="col-md-5">
                <img class="featurette-image img-responsive" src="{{url('arx')}}img/screen_dev.png"
                     alt="Generic placeholder image">
            </div>
            <div class="col-md-7 text-middle">
                <h2 class="featurette-heading">As development kit <br/><span
                        class="text-muted">It will highlight your code</span></h2>
                <p class="lead">
                    Laravel and Symfony based, you will be sure that your project will follow the right conventions. We choose Laravel for his damn good easy learning syntaxe and conventions.
                </p>
            </div>
        </div>
        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-7">
                <h2 class="featurette-heading">As a back-end helper <br/><span
                        class="text-muted">You will produce a back-office quickly</span></h2>

                <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod
                    semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus
                    commodo.</p>
            </div>
            <div class="col-md-5">
                <img class="featurette-image img-responsive" src="{{url('arx')}}img/screen_admin.jpg"
                     alt="Generic placeholder image">
            </div>
        </div>
        <hr class="featurette-divider">
        <div class="row featurette">
            <div class="col-md-5">
                <img class="featurette-image img-responsive" src="{{url('arx')}}img/screen_group.jpg"
                     alt="Generic placeholder image">
            </div>
            <div class="col-md-7">
                <h2 class="featurette-heading">With our community<br/><span
                        class="text-muted">You will be sure of the maintenance</span></h2>

                <p class="lead">Maintened by the open-source community and driven by an dedicated agency.</p>
            </div>
        </div>
        <hr class="featurette-divider">
        <!-- COLUMNS -->
        <div class="row">
            <div class="col-lg-3">
                <h2>Back-end</h2>

                <p>With Laravel Framework and Arx extension you have all weapons to </p>
            </div>
            <!-- /.col-lg-4 -->
            <div class="col-lg-3">
                <h2>Front-end</h2>

                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies
                    vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo
                    cursus magna.</p>
            </div>
            <!-- /.col-lg-4 -->
            <div class="col-lg-3">
                <h2>Design</h2>

                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies
                    vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo
                    cursus magna.</p>
            </div>
            <!-- /.col-lg-4 -->
            <div class="col-lg-3">
                <h2>Project management</h2>

                <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies
                    vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo
                    cursus magna.</p>
            </div>
            <!-- /.col-lg-4 -->
            <!-- /END THE FEATURETTES -->
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->
    @show

    @section('footer')
    <footer>
        <p class="pull-right"><a href="#">Back to top</a></p>

        <p>&copy; 2013 Cherrypulp, LLC. &middot; <a href="/privacy">Privacy</a> &middot; <a href="#">Code licensed under the The MIT License. Documentation licensed under <a href="http://creativecommons.org/licenses/by/3.0/">CC BY 3.0</a></p>
    </footer>
    <!--/footer-->
    @show
@stop