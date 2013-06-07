<?php 
global $hooked_css, $hooked_js;

if(empty($this->id))
{
    $this->id = u::randString();
}

if(is_array($this->data)):
?>
 <div class="accordion arx-accordion" id="accordion<?= $this->id ?>">
    <?php
    foreach($this->data as $key => $value) {
    ?>
    <div class="accordion-group">
         <div class="accordion-heading">
            <?= $value['title_prepend'] ?>
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion<?= $this->id ?>" href="#collapse<?= $key ?>">
                <?= $value['title'] ?>
            </a>
            <?= $value['title_append'] ?>
         </div>
         <div id="collapse<?= $key ?>" class="accordion-body collapse<?php if($value['open']) echo ' in'; ?>">
            <div class="accordion-inner">
                <?= $value['content'] ?>
            </div>
         </div>
     </div>
    <?php
    }
    ?>
 </div><!--/ #accordion<?= $this->id ?> -->
<?php
else:
    c_debug::notice('No data');
endif;
?>

