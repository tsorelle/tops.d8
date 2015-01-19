<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 4:49 PM
 */
use Tops\sys\TObjectContainer;


class DiContainerTest extends PHPUnit_Framework_TestCase {
    function  testContainerInstance() {
        $container = TObjectContainer::getContainer();
        $this->assertNotNull($container,'No container');
        $this->assertInstanceOf('\Symfony\Component\DependencyInjection\ContainerBuilder',$container);
    }

    function testRegistration() {
        TObjectContainer::register('testObject','Tops\test\TDiTestClass');
        $actual = TObjectContainer::get('testObject');
        $this->assertNotNull($actual,'No object instantiated');
        $this->assertInstanceOf('Tops\test\TDiTestClass',$actual);
    }



    function testConstructorInjection() {
        TObjectContainer::clear();
        TObjectContainer::register('argObject','Tops\test\TDiTestClass');
        $actual = TObjectContainer::get('argObject');
        $this->assertNotNull($actual,'No object instantiated');
        $this->assertInstanceOf('Tops\test\TDiTestClass',$actual);


        TObjectContainer::register('testObject','Tops\test\TDiTestClass2','argObject');
        $actual = TObjectContainer::get('testObject');
        $this->assertNotNull($actual,'No object instantiated');
        $this->assertInstanceOf('Tops\test\TDiTestClass2',$actual);

        $this->assertNotNull($actual->testClass, 'No injected class.');
        $this->assertInstanceOf('Tops\test\TDiTestClass',$actual->testClass);
    }

    function testDiConfigYml() {
        TObjectContainer::clear();

        TObjectContainer::register('testObject2','Tops\test\TSmokeTest');
        TObjectContainer::loadConfig("testDiConfig.yml",__DIR__);
        // TObjectContainer::loadConfig("di.yml");
        $actual = TObjectContainer::get('argObject');
        $this->assertNotNull($actual,'No object instantiated');
        $this->assertInstanceOf('Tops\test\TDiTestClass',$actual);


        $actual = TObjectContainer::get('testObject');
        $this->assertNotNull($actual,'No object instantiated');
        $this->assertInstanceOf('Tops\test\TDiTestClass2',$actual);

        $this->assertNotNull($actual->testClass, 'No injected class.');
        $this->assertInstanceOf('Tops\test\TDiTestClass',$actual->testClass);

        $actual = TObjectContainer::get('testObject2');
        $this->assertNotNull($actual,'No object instantiated');
        $this->assertInstanceOf('Tops\test\TSmokeTest',$actual);


    }

    function testConfigManager() {
        TObjectContainer::clear();
        TObjectContainer::register('configManager','Tops\sys\TYmlConfigManager');
        $actual = TObjectContainer::get('configManager');
        $this->assertNotNull($actual,'No object instantiated');
        $this->assertInstanceOf('Tops\sys\TYmlConfigManager',$actual);

    }

}
