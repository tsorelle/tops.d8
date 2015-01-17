<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/9/2015
 * Time: 1:15 PM
 */
namespace Tops\services;
use Tops\sys\TConfig;

class TServiceFactory implements IServiceFactory {

    public $namespace;
    public function  __construct($namespace = null) {
        if ($namespace === null) {
            $namespaces = (new TConfig("appsettings"))->Value("namespaces");
            if ($namespaces == null) {
                throw new \Exception("namespaces section not found in appsettings.yml.");
            }
            $namespace = '\\'.$namespaces['root'] . '\\' . $namespaces['services'];
        }
        $this->namespace = $namespace;
    }

    function CreateService($serviceId)
    {
        $className = $this->namespace.'\T'.$serviceId.'Command';
         return new $className();
    }
}