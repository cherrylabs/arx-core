<?php namespace Arx;

/**
* 
* Abstract template_Plugin class.
* 
* @package template
* 
* @author Paul M. Jones <pmjones@ciaweb.net>
* 
* @license http://www.gnu.org/copyleft/lesser.html LGPL
* 
* @version $Id: Plugin.php,v 1.5 2005/04/29 16:23:50 pmjones Exp $
*
*/

/**
* 
* Abstract template_Plugin class.
*
* You have to extend this class for it to be useful; e.g., "class
* template_Plugin_example extends Savant2_Plugin".  Be sure to add a
* method named for the plugin itself; e.g., "function example()".
* 
* @package template
* 
* @author Paul M. Jones <pmjones@ciaweb.net>
* 
*/

abstract class c_template_Plugin {
	
	/**
	* 
	* Reference to the calling Savant object.
	* 
	* @access protected
	* 
	* @var object
	* 
	*/
	
	protected $Savant = null;
	
	
	/**
	* 
	* Constructor.
	* 
	* @access public
	* 
	* @param array $conf An array of configuration keys and values for
	* this plugin.
	* 
	* @return void
	* 
	*/
	
	public function __construct($conf = null)
	{
		settype($conf, 'array');
		foreach ($conf as $key => $val) {
			$this->$key = $val;
		}
	}
}
?>