<?php namespace Arx;
use Illuminate\Routing\UrlGenerator;
class h_html extends \Illuminate\Html\HtmlBuilder
{

    public static function br($num = 1)
    {
        return str_repeat("<br />", $num);
    }

    

}