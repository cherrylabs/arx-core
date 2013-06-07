<?php //predie($this); ?>
<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="fr" dir="ltr"><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="fr" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="fr" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="ie8" lang="fr" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="<?= c_config('lang') ?>" dir="ltr"><!--<![endif]-->
<head>
<?= $this->fetch('head') ?>
</head>
<body <?= $this->_body->attr ?>>
	<div class="container-fluid">

		<div class="row-fluid">
				<?php 
					// write from controller $this->content()
					echo $this->content; 
				?>
		</div>
		
	</div>

<?php echo $this->fetch('footer') ?>
</body>
</html>