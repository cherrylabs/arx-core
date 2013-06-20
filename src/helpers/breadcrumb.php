<?php
/**
 * h_breadcrumb
 *
 * @author Daniel Sum <daniel@cherrylabs.net>
 * @link http://www.cherrylabs.net
 * @copyright Copyright &copy; 2010-2012 cherrylabs.net
 * @license http://www.cherrylabs.net/licence
 * @package arx
 * @since 1.0
 */

class h_breadcrumb extends c_helper{

	var $default = 'standard';
	var $aOpts = array(
			'ul' => array('class' => 'breadcrumb'),
			'li' => array(),
			'divider' => '<span class="divider">></span>' 
		);

	function __construct($mVars, $opts = array()){
		return $this->standard($mVars, $opts);
	}

	function _setOpts($opts){
		return array_merge(self::$aOpts, $opts);
	}


	public static function standard($mVars, $opts = null){
		
		$msg .= '<ul '.c_html::attributes($opts['ul']).'>';

		foreach ($mVars as $key => $value) {
			$attr = $opts['li'];
			if($key == 0 || $value['first']){
				$attr['class'] = $attr['class'].' first';
			}
			if($key == (count($mVars) - 1) || $value['last']){
				$attr['class'] = $attr['class'].' last';
			}

			$msg .= '<li '.c_html::attributes($attr).'><a href="'.$value['href'].'">'.$value['name'].'</a>'.$opts['divider'].'</li>';
		}
		$msg .= '</ul>';

		return $msg;
	}

}