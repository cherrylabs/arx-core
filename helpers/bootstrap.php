<?php

class h_bootstrap extends c_helper{


	static function btn($value, $attr = array())
	{

		$attr['_value'] = $value;

		if (!isset($attr['tag']))
		{
			$attr['tag'] = 'a';
		} else {
			
			$attr['tag'] = 'a';

			unset($attr['tag']);
		}


		if(!isset($attr['class']))
		{
			$attr['class'] = 'btn';
		}

		if(isset($attr['icon']))
		{
			$attr['_icon'] = '<i class="icon-'.$attr['icon'].'"></i> ';
		}

		$attr['_attr'] = array_diff($attr, array('tag', 'icon'));

		return u::strtr('<{_tag} {_attr}>{_icon}{_value}</{_tag}>', $attr);
	}
}