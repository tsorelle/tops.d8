<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/1/2015
 * Time: 7:24 AM
 */

namespace Tops\sys;


use Monolog\Logger;

class TExceptionHandler {
    private $policies;

    const RecoverableErrorPolicy = 'application-recoverable';
    const FatalErrorPolicy = 'application-fatal';
    const WarningPolicy = 'application-warning';

    public static function setErrorHandler($functionName = "TExceptionHandler::errorHandler", $errorTypes = E_ALL) {
        set_error_handler($functionName,$errorTypes);
    }

    public static function errorHandler($errno, $errstr, $errfile, $errline ) {
        if (!(error_reporting() & $errno)) {
            // This error code is not included in error_reporting
            return false;
        }
        throw new TErrorException($errstr, 0, $errno, $errfile, $errline);
    }



    public function __construct(IConfigManager $config = null) {
        $policies = array();
        if ($config) {
            $this->configure($config);
        }
    }

    public function configure(IConfigManager $config)
    {
        $configuration = $config->getLocal('appsettings','exceptions');
        $this->addPolicies($configuration);
    }

    public function addPolicies(IConfiguration $configuration) {

    }

    public function addPolicy($name, $notifyRethrow=false, $logName='errors',$level=Logger::ERROR) {

    }




}