var oTable;
$(function(){
	oTable = $('.arx-table').dataTable({
   		iDisplayLength: 1000,
			bProcessing: true,
			bServerSide: true,
			bRetrieve: true,
			sAjaxSource: 'lib/a.dataProcessing.php?extraColumnsNb=3',
			fnDrawCallback: function () {
	        	 $('.arx-table tr').each(function(index) {
	        	 	var id = $(this).children(':nth(0)').html();
	        	 	var name = $(this).children(':nth(1)').html();
	        	 	var isocode = $(this).children(':nth(2)').html();
	        	 	
	        	 	$(this).attr('id','tr|'+name+'|'+isocode);
	        	 	$(this).children(':nth(0)').attr('id','id|'+id).attr('class','id');
	        	 	$(this).children(':nth(1)').attr('id','name|'+id).attr('class','name');
	        	 	$(this).children(':nth(2)').attr('id','isocode|'+id).attr('class','isocode');
	        	 	$(this).children(':nth(3)').attr('id','value|'+id).attr('class','value');
	        	 	$(this).children(':nth(4)').attr('id','context|'+id).attr('class','context');
				 });
			}
	});
});