<?php
/**
 * Created by JetBrains PhpStorm.
 * User: danielsum
 * Date: 10/06/13
 * Time: 23:20
 * To change this template use File | Settings | File Templates.
 */

require '../arx.php';

class ArxTest extends PHPUnit_Framework_TestCase {
    function testApp(){
        $app = new arx();

        $this->assertAttributeInstanceOf('arx');
    }
}
