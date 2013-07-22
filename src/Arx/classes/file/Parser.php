<?php namespace Arx\classes\file;

use DOMXPath, DOMDocument;
use Symfony\Component\CssSelector\CssSelector;
use Arx\classes\Container;

class Parser extends Container{

    public $content;
    public $xpath;
    public $path;

    public function __construct(){}

    public static function document($path){
        $instance = new self();
        $instance->path = $path;
        $instance->doc = new \DOMDocument();
        $instance->xpath = new DOMXPath($instance->doc);
        return $instance;
    }

    public static function url($url){

        libxml_use_internal_errors(TRUE);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        $doc = new DOMDocument();
        $doc->loadHTML($content);
        libxml_clear_errors();
        $instance = new self;
        $instance->path = $url;
        $instance->xpath = new DOMXPath($doc);
        $instance->content = $content;
        return $instance;
    }

    public function query($query){
        $query = CssSelector::toXPath($query);
        return $this->xpath->query($query);
    }

    public static function DOMinnerHTML($element)
    {
        $innerHTML = "";
        $children = $element->childNodes;
        foreach ($children as $child)
        {
            $tmp_dom = new DOMDocument();
            $tmp_dom->appendChild($tmp_dom->importNode($child, true));
            $innerHTML.=trim($tmp_dom->saveHTML());
        }
        return $innerHTML;
    }
}