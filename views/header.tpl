<style>
    body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
    }
</style>
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#"><?= \Arx\c_config::get('app.name') ?></a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                <?= $this->a_mustache()->render('{{#test}}<li><a href="#">{{.}}</a></li>{{/test}}', array('test' => array('Home', 'About') )); ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>