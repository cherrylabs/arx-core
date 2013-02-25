<?php

/**
	* Default bottom auto-generator
	* @file
	*	
	* @package
	* @author Daniel Sum
	* @link 	@endlink
	* @see 
	* @description
	* 
	* @code 	@endcode
	* @comments
	* @todo 
*/

?>
<!-- Prompt IE 6 users to install Chrome Frame. Remove this if you want to support IE 6. - chromium.org/developers/how-tos/chrome-frame-getting-started -->
<!--[if lt IE 7]>
<script defer src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
<script defer>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
<?php 

echo ,0l$this->_js;

if(isset($GLOBALS['google']['api_key'])):
?>
	<script>
	var _gaq=[['_setAccount','UA-XXXXXXXX-X'],['_trackPageview'],['_trackPageLoadTime']];
	(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
	g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
	s.parentNode.insertBefore(g,s)}(document,'script'));
	</script>
<?php 
endif;
?>