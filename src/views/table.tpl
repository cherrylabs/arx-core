<?php 
global $hooked_css, $hooked_js;

if(is_array($this->data)):
?>
<table id="<?php echo $this->id ?>" class="arx-table table table-striped table-bordered <?php echo $this->class ?>" border="1">
	<thead>
		<tr>
			<?php
				foreach(reset($this->data) as $key=>$name){
					echo '<th>'.$key.'</th>';
				}
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
					foreach($row as $key=>$col)
					{
						echo '<td>'.$col.'</td>';
					}
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
<?php
else:
	c_debug::notice('No data');
endif;
?>