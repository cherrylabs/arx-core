<?php global $hooked_css, $hooked_js ; ?>
<form method="post" action="" <?php echo C_HTML::attributes($this->_formAttributes) ?>>
<table id="<?php echo $this->id ?>" class="arx-table table table-striped table-bordered <?php echo $this->class ?>" border="1">
	<thead>
		<tr>
			<?php 
				echo '<th><input type="checkbox" /></th>';
				foreach(reset($this->data) as $key=>$name){
					echo '<th>'.$key.'</th>';
				}
				echo '<th>delete</th>';
				echo '<th>edit</th>';
			?>
		</tr>
	</thead>
	<tbody>
		<?php
		
		if($this->_ajax != true)
		{
		
			foreach($this->data as $key=>$row)
			{
				
				echo '<tr>';
					echo '<td><input type="checkbox" /></td>';
					foreach($row as $key=>$col)
					{
						echo '<td>'.$col.'</td>';
					}
					echo '<td class="a-delete" id="row-'.$row['id'].'"><a href="?action=delete&id='.$row['id'].'"><i class="arx-delete icon-trash"></i></a></td>';
					echo '<td class="a-update" id="row-'.$row['id'].'"><a href="?action=edit&id='.$row['id'].'"><i class="arx-update icon-pencil"></i></a></td>';
				echo '</tr>';
			}
		}
		else
		{
			echo '<!--AJAXCALL-->';
		}
		?>
	</tbody>
</table>
<div>
	<button><?php echo ('Delete') ?></button>
	<button><?php echo ('Add') ?></button>
</div>
</form>