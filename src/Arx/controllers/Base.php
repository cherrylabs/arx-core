<?php
/**
 * Base.php.
 *
 * @project : cherrylabs
 * @author : Daniel Sum <daniel@cherrypulp.com>
 */

namespace Arx\controllers;

use Controller;
use View;
/*
 * Betterbase controller and usefull function like setContent method
 */

class Base extends Controller {

    protected $layout;

    public function setContent($layout, $data = array()){
        return $this->layout->content = View::make($layout, $data);
    }

    public function viewContent($layout, $data = array()){
        return $this->layout->content = View::make($layout, $data);
    }
} 