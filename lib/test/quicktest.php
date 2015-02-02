<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/31/2014
 * Time: 7:54 AM
 */

// Use for adhoc tests.
require_once(__DIR__.'/../Tops/start/autoload.php');
require_once(__DIR__.'/../Tops/start/init.php');
require_once(__DIR__.'/../App/start/init.php');

// use for ad hoc tests

try {
    // throw new \Exception("don't catch");
    trigger_error("test handling");
    // \Tops\sys\TErrorException("Hello exception",1,2,"foo",3);
}
catch (\Tops\sys\IException $ex) {
    print "Exception message".$ex->getMessage()."\n\n";
    print "Exception Severity ".$ex->getSeverity()."\n\n";
    // print "$ex";
}
catch (\Exception $ex) {
    print $ex->getMessage();
}

