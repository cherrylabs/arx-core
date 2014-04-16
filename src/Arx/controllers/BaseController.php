<?php namespace Arx;

use Controller, View;
use Arx\classes\Arr;

/**
 * Class BaseController
 *
 * Better BaseController with tpl Handler
 *
 * @package Arx
 */
class BaseController extends Controller {

    protected $layout;

    protected $data = array();

    /**
     * @param array $otherDataToMerge
     * @param bool $addToCommon
     * @return mixed
     */
    public function getCommonVars($otherDataToMerge = array(), $addToCommon = false)
    {

        $data = Arr::merge($this->data, $otherDataToMerge);

        if ($addToCommon) {
            $this->data = $data;
        }

        return $data;
    } // getCommonVars

    /**
     * Same than View make but injects common vars
     *
     * @param $layout
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function viewMake($layout, $data = array())
    {
        $data = array_merge($data, array('body' => array(
            'attributes' => array('class' => 'tpl-' . $layout)
        )));

        $data = $this->getCommonVars($data);

        return View::make($layout, $data);
    } // viewMake


    /**
     * Auto-assign element to the layout content
     *
     * @param $layout
     * @param array $data
     * @return \Illuminate\View\View
     */
    public function viewContent($layout, $data = array())
    {
        $data = array_merge($data, array('body' => array(
            'attributes' => array('class' => 'tpl-' . $layout)
        )));

        return $this->layout->content = View::make($layout, $this->getCommonVars($data));
    } // viewContent

} 