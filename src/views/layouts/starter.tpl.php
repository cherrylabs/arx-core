@extends('arx::layouts.bootstrap')

@section('body')
<body class="page-starter">

    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<% $this->project['link'] ?: Lang::get('project.link') %>"><% $this->project['name'] ?: Lang::get('project.name') %></a>
            </div>
            <div class="collapse navbar-collapse">
                    @section('nav')
                    <?php
                        echo  \Arx\helpers\Bootstrap::nav(
                        $nav,
                        array('parent@' => array('class' => 'nav navbar-nav')));
                    ?>
                    @show
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <div class="container starter-template">
        @section('content')
        <?php
        if (isset($content)):
            echo $content;
        else:
        ?>
        <div class="starter-template">
            <h1>Bootstrap starter template</h1>
            <p class="lead">Define a $content var to change this content.</p>
        </div>
        <?php
        endif;
        ?>
        @show
    </div> <!-- /container -->
</body>
@stop