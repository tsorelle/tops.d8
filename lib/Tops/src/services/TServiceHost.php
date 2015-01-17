<?php
/**
 * Created by PhpStorm.
 * User: tsorelle
 * Date: 2/28/14
 * Time: 6:42 AM
 */
namespace Tops\services;
use \Symfony\Component\HttpFoundation\Request;

class TServiceHost {

    private static $serviceFactory;
    public static function SetNamespace($namespace = null) {
        self::$serviceFactory = new TServiceFactory($namespace);
    }

    public static function ExecuteRequest($request = null) {
        if (empty($request)) {
            $request = Request::createFromGlobals();
        }

        $commandId = $request->get('serviceCode');
        if  (empty($commandId)) {
            throw new \Exception('No service command id was in request');
        }

        $input = null;
        $serviceRequest= $request->get('request');
        $requestMethod = $request->getMethod();

        if ($requestMethod == 'POST') {
            if ($serviceRequest != null) {
                $input = json_decode($serviceRequest);
            }
        }
        else if ($requestMethod == 'GET') {
            if ($serviceRequest != null) {
                $input = $serviceRequest;
            }
        }
        else
            throw new \Exception('Unsupported request method: '.$request->getMethod());

        return self::Execute($commandId, $input);
    }

    private function getServiceFactory() {
        if (self::$serviceFactory == null) {
            $namespaces = (new TConfig("appsettings"))->Value("namespaces");
            if ($namespaces == null) {
                throw new \Exception("namespaces section not found in appsettings.yml.");
            }
            $namespace = '\\'.$namespaces['root'] . '\\' . $namespaces['services'];
            self::SetNamespace($namespace);
        }
        return self::$serviceFactory;
    }

    public static function CreateServiceCommand(IServiceFactory $factory, $serviceId) {
        return $factory->CreateService($serviceId);
    }

    public static function Execute($commandId, $input) {
        $command = self::CreateServiceCommand(self::$serviceFactory, $commandId);
        if (empty($command))
            throw new \Exception("Unable to create service command '$commandId'");
        return $command->Execute($input);
    }
} 