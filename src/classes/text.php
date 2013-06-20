<?php defined('SYSPATH') or die('No direct script access.');

require_once ARX_INC .DS. 'simple_html_dom.php';

class c_Text extends Kohana_Text
{
    public function __construct()
    {

    }

    public static function extractImages($text)
    {
        $html = str_get_html($text);

        predie($html->find('img',0));
    }
}

class Text extends c_Text {}
