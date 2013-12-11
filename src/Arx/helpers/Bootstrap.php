<?php
/**
 * bootstrap helper class
 *
 * @project : arx-contrib
 * @author  : Daniel Sum <daniel@cherrypulp.com>
 */

namespace Arx\helpers;

use Arx\classes\Helper;
use HTML, Form;

class Bootstrap extends Helper
{
    /**
     * Navbar helper => generate a navbar helpers
     * @todo better navigation handler
     */
    public static function nav($data, $params = array())
    {
        $defParams = array(
            'active' => null,
            'parent' => 'ul',
            'child' => 'li',
            'parent@' => array('class' => 'nav'),
            'child@' => array(),
            'link@' => array()
        );

        $params = array_merge($defParams, $params);

        $html = '<' . $params['parent'] . ' ' . HTML::attributes($params['parent@']) . '>';

        foreach ($data as $key => $value) {
            $html .= '<' . $params['child'] . ' ' . HTML::attributes($params['child@']) . '>';
            $html .= '<a href="' . $value['link'] . '"' . HTML::attributes($params['link@']) . '>' . $value['name'] . '</a>';
            $html .= '</' . $params['child'] . '>';
        }

        $html .= '</' . $params['parent'] . '>';

        return $html;
    }

    public static function table($data, $params = array())
    {
        $defParams = array(
            'ajax' => false,
            'tfoot' => false,
            'table@' => array('class' => 'table'),
            'thead@' => array(),
            'tbody@' => array(),
            'tfoot@' => array()
        );

        $params = array_merge_recursive($defParams, $params);


        if (is_array($data)) {

            $html = '<table ' . HTML::attributes($params['table@']) . '><thead ' . HTML::attributes($params['thead@']) . '><tr>';
            foreach (reset($data) as $key => $name) {
                $html .= '<th>' . $key . '</th>';
            }
            $html .= '</tr></thead><tbody>';

            if ($params['ajax'] != true) {

                foreach ($data as $key => $row) {

                    $html .= '<tr>';
                    foreach ($row as $key => $col) {
                        $html .= '<td>' . $col . '</td>';
                    }
                    $html .= '</tr>';
                }
            } else {
                $html .= '<!--AJAXCALL-->';
            }
            $html .= '</tbody>';

            $html .= '</table>';

            return $html;
        }
    }

    /**
     * Breadcrumb helper for bootstrap
     *
     * @param       $data
     * @param array $params
     *
     * @return string
     */
    public static function breadcrumb($data, $params = array())
    {
        $defParams = array(
            'parent' => 'ul',
            'child' => 'li',
            'divider' => '<span class="divider">></span>',
            'parent@' => array('class' => 'breadcrumb'),
            'child@' => array()
        );

        $params = array_merge_recursive($defParams, $params);

        $msg = '<' . $params['parent'] . ' ' . HTML::attributes($params['parent@']) . '>';

        foreach ($data as $key => $value) {
            $attr = $params['li'];
            if ($key == 0 || $value['first']) {
                $params['child@']['class'] = $params['child@']['class'] . ' first';
            }
            if ($key == (count($data) - 1) || $value['last']) {
                $params['child@']['class'] = $params['child@']['class'] . ' last';
            }

            $msg .= '<' . $params['child'] . ' ' . HTML::attributes($params['child@']) . '><a href="' . $value['link'] . '">' . $value['name'] . '</a>' . $params['divider'] . '</' . $params['child'] . '>';
        }
        $msg .= '</' . $params['parent'] . '>';

        return $msg;
    }

    /**
     * Form helper for Bootstrap
     *
     * @return string
     */
    public static function formGroup(){

        $aParams = func_get_args();
        $label = $aParams[0];
        $type = $aParams[1];
        $name = $aParams[2];
        unset($aParams[0], $aParams[1]);

        $html = '<div class="form-group" id="form-' . $name . '">';

        $html .= Form::label($name, $label);

        $html .= call_user_func_array(array('Form', $type), $aParams);

        $html .= '</div>';

        return $html;
    }
}