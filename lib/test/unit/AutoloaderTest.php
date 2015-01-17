<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/10/2015
 * Time: 7:14 AM
 */

class AutoloaderTest extends PHPUnit_Framework_TestCase {
    /**
     * Check to see if class loaded by autoloader.
     */
    public function testFindTopsClass() {
        $this->findClass('\Tops\test\TSmokeTest');
        $this->findClass('\App\test\TAppSmokeTest');
    }

    private function findClass($className) {
        $this->assertTrue(class_exists($className),"Class not found '$className'");
    }
}
