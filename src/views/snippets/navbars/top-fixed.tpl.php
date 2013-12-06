<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="<% $this->project['url'] ? : '/' %>"><% $this->project['name'] ?: 'Project name' %></a>
            <div class="nav-collapse collapse">
                <ul class="nav">
                    <?php foreach ($this->navBar as $key => $value): ?>
                        <li><a href="<% $value['link'] %>" <% Html::attributes($value['attributes']) %>><% $value['name'] %></a></li>
                        <? if (isset($value['children'])): ?>

                        <? endif; ?>
                    <?php endforeach ?>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
</div>