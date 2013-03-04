<?php
if(isset($this->_header)):

$data = $this->_header;
?>
<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
    <div class="container">
      <?php
        if (isset($data['project']))
        {
          echo u::strtr('<a class="brand" href="{url}">{name}</a>', $data['project']); 
        }
      ?>
      <div class="nav-collapse collapse">
        <ul class="nav">
          <?php
          foreach($data['nav'] as $key => $value)
          {
              echo u::strtr('<li class="{class}"><a href="{url}">{content}</a></li>', $value);
          }
          ?>
        </ul>
      </div><!--/.nav-collapse -->
    </div>
  </div>
</div>
<?php
endif;
?>