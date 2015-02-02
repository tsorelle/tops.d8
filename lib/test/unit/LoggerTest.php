<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/28/2015
 * Time: 11:55 AM
 */
use \Tops\sys\TLogger;

class LoggerTest extends PHPUnit_Framework_TestCase {
    public function testMonologAutoload() {
        $this->assertTrue(class_exists('\Monolog\Logger'));
    }

    public function testLoggerConfig() {
        $configMgr = new \Tops\sys\TYmlConfigManager();
        $mailer = new \Tops\sys\TSwiftMailer($configMgr);
        $logger = new \Tops\sys\TLogger($configMgr,$mailer);
        $errlog = $logger->getLog('errors');
        $this->assertNotNull($errlog);

    }

    public function testLoggerWrite() {
        $logger = new \Tops\sys\TLogger();
        $handler = new \Monolog\Handler\TestHandler();
        $monologger = new \Monolog\Logger('default');
        $monologger->pushHandler($handler);
        $logger->setLog('default',$monologger);
        $logger->writeError('Test error.');
        $this->assertTrue($handler->hasErrorRecords());
    }


}
