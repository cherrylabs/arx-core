//<script type="text/javascript">
var oTable;
$(function(){
	oTable = $('.arx-table').dataTable({
   		iDisplayLength: 10000,
   		<?php
   		if($this->_ajax == true):
   		?>
			bProcessing: true,
			bServerSide: true,
			bRetrieve: true,
			sAjaxSource: 'lib/a.dataProcessing.php?extraColumnsNb=3',
			<?php
			endif;
			?>
			
			/*
			fnDrawCallback: function () {
	        	 $('.arx-table tr').each(function(index) {
	        	 	var id = $(this).children(':nth(1)').html();
	        	 	var name = $(this).children(':nth(2)').html();
	        	 	var isocode = $(this).children(':nth(2)').html();
	        	 	
	        	 	$(this).attr('id','tr|'+name+'|'+isocode);
	        	 	$(this).children(':nth(0)').attr('id','id|'+id).attr('class','id');
	        	 	$(this).children(':nth(1)').attr('id','name|'+id).attr('class','name');
	        	 	$(this).children(':nth(2)').attr('id','isocode|'+id).attr('class','isocode');
	        	 	$(this).children(':nth(3)').attr('id','value|'+id).attr('class','value');
	        	 	$(this).children(':nth(4)').attr('id','context|'+id).attr('class','context');
				 });
			}*/
	});
	
	
	$('td', oTable.fnGetNodes()).editable( null, {
		"callback": function( sValue, y ) {
			var aPos = oTable.fnGetPosition( this );
			oTable.fnUpdate( sValue, aPos[0], aPos[1] );
		},
		"submitdata": function ( value, settings ) {
			return {
				"row_id": this.parentNode.getAttribute('id'),
				"column": oTable.fnGetPosition( this )[2]
			};
		},
		"height": "14px"
	} );
	
	
	$('.arx-add').on('click', function(e){
		e.preventDefault();
	
		var html = $('.arx-table tbody').children(':nth(0)').clone();
		
		html.effect('highlight', 'slow', 100);
		html.find('td:nth(0)').html('<a href="" ><i class="icon-minus"></i></a>');
		html.find('td:nth(1)').html('<a href="" ><i class="icon-save"></i></a>');
		$("td:last-child", html).prev().html('<a href="" ><i class="icon-minus"></i></a>'); 
		$("td:last-child", html).html('<a href="" ><i class="icon-save"></i></a>'); 
		
		
		$('.arx-table').append(html);
		console.log(html);
		
	})
	
});
//</script>