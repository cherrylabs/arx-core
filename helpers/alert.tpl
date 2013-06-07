<?php
/**
 * Alert helpers
 * @author Daniel Sum <daniel@cherrylabs.net>
 */

if($this->alert)
{
	extract($this->alert);
?>

	<div class="alert alert-<?= $type ? $type : 'block' ?>">
	<?= $noclose ? '' : '<button type="button" class="close" data-dismiss="alert">&times;</button>' ?>
	<?= $title ? '<h4>'. $title . '</h4>' : '' ?>
	<?= $content ?>
	</div>

<?php
}
?>