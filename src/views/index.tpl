<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="fr" dir="ltr"><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="fr" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="fr" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="ie8" lang="fr" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="<?= c_config('lang') ?>" dir="ltr"><!--<![endif]-->
<head>
<?= $this->fetch('head') ?>
<?= c_hook::output('css') ?>
</head>
<body <?= $this->_body->attr ?>>
	<div class="container-fluid">
	<div class="row">

		<div class="span3">
			<?= $this->fetch('sidebar'); ?>
		</div>

		<div class="span6">
			
			<?= $this->fetch('form-data-blog'); ?>
		</div>
		
	</div>

<?php echo $this->fetch('footer') ?>
<?php

c_hook::js(ARX_JS.DS.'jquery.notifications.js');
echo c_hook::output('js'); 

if(!empty($this->notify)):
?>

<script type="text/javascript">
	$(function() {
	    $.notifications({
	        title: '<?= $this->notify["title"]?>',
	        content: '<?= $this->notify["content"]?>'
	    });
	});
</script>
<?php
endif;
?>

<script type="text/javascript">
	$(function(){
		<?php echo c_hook::output('domReady') ?>
	})
</script>
</body>
</html>