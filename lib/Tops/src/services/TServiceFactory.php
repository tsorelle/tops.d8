<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/9/2015
 * Time: 1:15 PM
 */
namespace Tops\services;
use Tops\sys\IConfigManager;
use Tops\sys\IConfiguration;

class TServiceFactory implements IServiceFactory {

    public $namespace;
    public function  __construct(IConfigManager $configManager) {
        $appConfig = $configManager->get("appsettings");
        $this->initialize($appConfig);
    }

    private function initialize(IConfiguration $appConfig) {
        $namespaces = $appConfig->Value("namespaces");
        if ($namespaces == null) {
            throw new \Exception("namespaces section not found in appsettings.yml.");
        }
        $namespace = '\\'.$namespaces['root'] . '\\' . $namespaces['services'];
        $this->namespace = $namespace;
    }

    function CreateService($serviceId)
    {
        $className = $this->namespace.'\T'.$serviceId.'Command';
         return new $className();
    }
}