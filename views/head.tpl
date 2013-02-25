<?php

/**
	* Default head auto-generator
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

<meta charset="UTF-8" />
<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1" /><![endif]-->
<!--[if lt IE 7]><meta http-equiv="imagetoolbar" content="false" /><![endif]-->

<?php

if(!isset($this->_head))
{
	$this->_head->title = DIR_FILE;

	$this->_head->meta = array('description' => array('test' => 'tamer'));
	
	$this->_head->css = array(LIBS_CSS.DS.'style.css');
}

// Defining title
if(isset($this->_head->title))
{
	echo '<title>'.$this->_head->title.'</title>'."\n";
}

if(isset($this->_head->meta))
{
	foreach($this->_head->meta as $key=>$meta)
	{
		if(!is_array($meta))
			echo '<meta name="'.$key.'" content="'.$meta.'" />'."\n";
		else
			echo '<meta name="'.$key.'" '.c_html::attributes($meta).' />'."\n";
		
	}
}

if(isset($this->_head->link))
{
	foreach($this->_head->link as $attributes)
	{
			echo '<link '.c_html::attributes($attributes).' />'."\n";	
	}
}