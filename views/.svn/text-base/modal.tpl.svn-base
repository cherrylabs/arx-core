<?php
/*----- DEFAULT CONFIG -----*/

if(!isset($this->header->attr))
	$this->header->attr = array("class" => "modal-header");

if(!isset($this->body->attr))
	$this->body->attr = array("class" => "modal-body");

if(!isset($this->footer->attr))
	$this->footer->attr = array("class" => "modal-footer");

?>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div <?= c_HTML::attributes($this->footer->attr) ?>>
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
		<h3 id="myModalLabel">Modal header</h3>
	</div>
	<div <?= c_HTML::attributes($this->footer->attr) ?>>
		<?= $this->body ?>
	</div>
	<div <?= c_HTML::attributes($this->footer->attr) ?>>
		<?= $this->footer ?>
	</div>
</div>