<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/23/2015
 * Time: 5:33 AM
 */

class swiftMailerTest extends PHPUnit_Framework_TestCase {
    public function testSwiftMailerSend() {
        // $this->assertTrue(true); // disabled for now


        $configManager = new \Tops\sys\TYmlConfigManager();
        if ($configManager->getEnvironment() == 'development') {
            $mailer = new \Tops\sys\TSwiftMailer($configManager);

            $message = new \Tops\sys\TEMailMessage();
            $message->addRecipient('tls@2quakers.net',"Terry SoRelle");
            $message->setSubject("Test message");
            $message->setSender('foo@bar.com',"Roo Barr");
            $message->setHtmlMessageBody('<h1>Hello world.</h1>');

            $result = $mailer->send($message);

            $this->assertGreaterThan(0,$result);


        }
        else {
            assertTrue(true,'Do not run this test in production environment');
        }
    }

}
