<?php global $hooked_css, $hooked_js ; 
if(!isset($this->id))
{
	$this->id = u::randString();
}
if(!$this->_attr)
{
	$this->_attr = array();
}
?>
<form id="<?php echo $this->id ?>" <?php echo C_HTML::attributes($this->_attr) ?>>
<?= $this->prepend ?>
<table class="arx-table table table-striped table-bordered <?php echo $this->class ?>" border="1">
	<thead>
		<tr>
			<?php 
				echo '<th><input type="checkbox" class="arx-selectAll" onclick="table_selectCheckAll(\''.$this->id.'\')"/></th>';
				foreach(reset($this->data) as $key=>$name)
				{
					if(substr($key, 0,1) != '_')
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
					echo '<td><input type="checkbox" name="ids['.$row['id'].']" value="true" '.($row['_checked'] ? 'checked="checked"' : '').'/></td>';
					foreach($row as $key=>$col)
					{
						if(substr($key, 0,1) != '_')
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
<?= $this->append ?>
</form>
<script type="text/javascript">
function table_selectCheckAll(formId) {
        var frmId=document.getElementById(formId);
        var reclen =  frmId.length;
        for(i=0;i<reclen;i++) {
                if(frmId.elements[i].checked==true) {
                        frmId.elements[i].checked=false;       
                } else {
                        frmId.elements[i].checked=true;        
                }
        }
}
</script>