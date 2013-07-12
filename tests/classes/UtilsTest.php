<?php
/**
 * UtilsTest.php.
 * @project : arx
 * @author : danielsum
 */

use Arx\classes\Utils;

class UtilsTest extends PHPUnit_Framework_TestCase {

    public function testAlias(){
        Utils::alias('preTest', '\\Arx\\classes\\Utils::pre');
        $this->assertEquals(Utils::epre('test'), preTest('test'));
    }

}