<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="<?= ARX_JS ?>/bootstrap.min.js"></script>
<script src="<?= ARX_JS ?>/sparkline.js"></script>
<script src="<?= ARX_JS ?>/morris.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.dataTables.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.masonry.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.imagesloaded.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.facybox.js"></script>
<script src="<?= ARX_JS ?>/jquery.alertify.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.knob.js"></script>
<script src="<?= ARX_JS ?>/fullcalendar.min.js"></script>
<script src="<?= ARX_JS ?>/jquery.gritter.min.js"></script>
<script src="<?= ARX_JS ?>/bootstrap-datepicker.js"></script>

<script src="<?= ARX_JS ?>/script.js"></script>

<script src="<?= APP_URL ?>/assets/js/datamanager.js"></script>
<?php
	echo c_hook::output('js');
?>

<script type="text/javascript">
	$(function () {
		<?php echo c_hook::output('domReady') ?>
	});
</script>