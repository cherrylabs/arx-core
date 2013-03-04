<div class="row">
	<form action="" method="post" accept-charset="utf-8" enctype="multipart/form-data">

		<textarea name="comment" class="wysiwig"><?= $this->fill->description ?></textarea>
		
		<div>
			<br />
			<input type="file" class="btn multi" name="file[]" />
		</div>
		<br /><br />
		<div class="row">
			<div class="span8">
			</div>
			<div class="span6">
				<button name="inscription" class="btn blue pull-right"><?= lg("Envoyer") ?></button>
			</div>
		</div>
	</form>
</div>