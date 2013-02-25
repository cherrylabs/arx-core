<?php defined('SYSPATH') or die('No direct script access.');

require_once DIR_CLASSES.DS.'kohana.php';

require_once DIR_CLASSES.DS.'kohana/html.php';

class c_HTML extends Kohana_HTML
{

    public static function ul($mVars, $tpl)
    {

        $_odd = 'odd';
        $_even = 'even';
        $_first = 'first';
        $_last = 'last';
        $_nbprefix = 'n-';

        $_iLiStart = strpos($tpl, '<li');
        $_iLiEnd = strrpos($tpl, '</li>') +1;

        $_s = substr($tpl, 0, $_iLiStart);

        $_sLi = substr($tpl, $_iLiStart, $_iLiEnd);

        $dynVars = self::getParams($_sLi);

        $key = 0;
        $nb = 1;

        $last = count($mVars) - 1;

        $aLis = array();

        foreach ($mVars as	$v) {

            $v['$key'] = $key;
            $v['$number'] = $nb;
            $v['$bool'] =  ($key & 1 ? $_odd : $_even);
            $v['$position'] = ($key == 0 ? $_first : ($key != $last ? $_nbprefix.$key : 'last' ));

            $aV = array();

            foreach ($dynVars[1] as $d) {
                $aV[$d] = $v[$d];
            }

            $_s .= str_replace($dynVars[0], $aV, $_sLi);

            $key++;
            $nb++;

        }

        $_s .= substr($tpl, $_iLiEnd + 4);

        return $_s;
    }

    public static function getVars($mVars, $dynVars)
    {
        ob_start();
        
        foreach ($mVars as	$v) {

            $v['$key'] = $key;
            $v['$number'] = $nb;
            $v['$bool'] =  ($key & 1 ? $_odd : $_even);
            $v['$position'] = ($key == 0 ? $_first : ($key != $last ? $_nbprefix.$key : 'last' ));

            $aV = array();

            foreach ($dynVars[1] as $d) {
                $aV[$d] = $v[$d];
            }
            $_s .= str_replace($dynVars[0], $aV, $_sLi);

            $key++;
            $nb++;

        }

        ob_end_flush();

        return $_s;
    }

    public static function css()
    {
        call_user_func_array('self::style', func_get_args());
    }


    public static function getObject($str = string)
    {
        return str_get_html($str);
    }

    public static function getParams($structure)
    {
        preg_match_all("/\{(.*?)}/", $structure, $out);

        return $out;
    }

}

class HTML extends c_HTML {}
