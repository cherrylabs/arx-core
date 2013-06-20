<?php 

class h_table{
	public function __construct($data){
		if(is_array($data)):
		?>
		<table id="<?php echo $this->id ?>" class="arx-table table table-striped table-bordered <?php echo $this->class ?>" border="1">
			<thead>
				<tr>
					<?php
						foreach(reset($data) as $key=>$name){
							echo '<th>'.$key.'</th>';
						}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
				
				if($this->_ajax != true)
				{
				
					foreach($data as $key=>$row)
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
	}
}