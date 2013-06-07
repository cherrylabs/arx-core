<!DOCTYPE html>
<!--[if IEMobile 7]><html class="iem7" lang="fr" dir="ltr"><![endif]-->
<!--[if lt IE 7]><html class="ie6" lang="fr" dir="ltr"><![endif]-->
<!--[if (IE 7)&(!IEMobile)]><html class="ie7" lang="fr" dir="ltr"><![endif]-->
<!--[if IE 8]><html class="ie8" lang="fr" dir="ltr"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!-->
<html lang="<?= Arx\c_config::get('lang') or 'en'; ?>" dir="ltr"><!--<![endif]-->
<head>
<?= $this->fetch('head') ?>
</head>
<body <?= u::issetOr('this->_body->attr') ?>>
	<div class="container-fluid">
		
		<?= $this->fetch('header') ?>

		<div class="row-fluid">
			<div class="span2">
				<?= $this->fetch('sidebar'); ?>
			</div>
			<div class="span10">
				<?php 
					// write from controller $this->content()
					echo u::issetOr('this->content');
				?>
			</div>
		</div>

		<!-- example modal -->
		<div id="modal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		  </div>
		  <div class="modal-body">

		  </div>
		  <div class="modal-footer">
		    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		    <button class="btn btn-primary">Save changes</button>
		  </div>
		</div>
		
	</div>

<?php echo $this->fetch('footer') ?>
</body>
</html>