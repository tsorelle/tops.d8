<?php
/**
 * Created by PhpStorm.
 * User: tsorelle
 * Date: 2/28/14
 * Time: 6:42 AM
 */
namespace Tops\services;
use \Symfony\Component\HttpFoundation\Request;
use Tops\sys\TObjectContainer;

/**
 * Class TServiceHost
 * @package Tops\services
 */
class TServiceHost {

    /**
     * @var TServiceHost
     */
    private static $instance;
    private static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = TObjectContainer::get('serviceHost');
        }
        return self::$instance;
    }

    /**
     * @var IServiceFactory
     */
    private $serviceFactory;

    public function __construct(IServiceFactory $serviceFactory) {
        $this->serviceFactory = $serviceFactory;
    }

    /**
     * @param null $request
     * @return TServiceResponse
     * @throws \Exception
     */
    public static function ExecuteRequest(Request $request = null)
    {
        return self::getInstance()->_executeRequest($request);
    }

    private function _executeRequest(Request $request) {
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

        return $this->_execute($commandId, $input);
    }


    /**
     * @param $commandId
     * @param $input
     * @return TServiceResponse
     * @throws \Exception
     */
    public static function Execute($commandId, $input) {
        return self::getInstance()->_execute($commandId, $input);
    }

    public function _execute($commandId, $input) {
        $command = $this->serviceFactory->CreateService($commandId);
        if (empty($command))
            throw new \Exception("Unable to create service command '$commandId'");
        return $command->Execute($input);
    }

} 