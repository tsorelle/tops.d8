<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/10/2015
 * Time: 8:04 AM
 */
use Tops\services;

class ServiceFactoryTest extends PHPUnit_Framework_TestCase {
    public function testCreateService() {

        // $service = $this->createService(new services\TServiceFactory('\App\services'), "TestService");
        // $factory = new services\TServiceFactory('\App\services');
        $factory = new services\TServiceFactory();

        $service = $this->createService($factory, "TestService");
        $this->assertNotNull($service,'Service not instantiated.');
        $this->assertInstanceOf('\App\services\TTestServiceCommand',$service);
        $this->assertInstanceOf('\Tops\services\TServiceCommand',$service);
        // $this->verifyService($service);
    }

    private function createService(Tops\Services\IServiceFactory $factory, $serviceId) {


        return $factory->CreateService($serviceId);

    }

}
