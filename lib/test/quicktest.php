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


$a = array(
  new \Tops\sys\TExceptionPolicy("one",40),
  new \Tops\sys\TExceptionPolicy( "two",100,false,""),
  new \Tops\sys\TExceptionPolicy("two",10)
);


$logger = new \Tops\sys\TLogger();
$logHandler = new \Monolog\Handler\TestHandler();
$monologger = new \Monolog\Logger("default");
$monologger->pushHandler($logHandler);
$logger->setLog('default',$monologger);

$handler = new \Tops\sys\TExceptionHandler($logger);
$handler->addPolicy( "snafus",\Tops\sys\TException::SeverityCritical,true,'default');
$handler->addPolicy("hickups",\Tops\sys\TException::SeverityMinor, false);
$handler->addPolicy("errors",\Tops\sys\TException::SeverityError,false,'default');


try {
  // trigger_error("A test error",E_ERROR);
  throw new \Tops\sys\TException("test error");
}
catch (\Exception $ex) {
  $rethrow = $handler->handleException($ex);
  $rethrow = $rethrow ? 'Yes' : 'No';
  $wasLogged = $logHandler->hasErrorRecords();

  print "Ex 1 was logged? $wasLogged, rethrow? $rethrow\n";
  // $this->assertTrue($logHandler->hasErrorRecords());
}

try {
  trigger_error("Another test error");
}
catch (\Exception $ex) {
  $rethrow = $handler->handleException($ex);
  $rethrow = $rethrow ? 'Yes' : 'No';
  $wasLogged = $logHandler->hasErrorRecords();

  print "Ex 2 was logged? $wasLogged, rethrow? $rethrow\n";
  // $this->assertTrue($logHandler->hasErrorRecords());
}

try {
  throw new \Tops\sys\TException("Error 3", \Tops\sys\TException::SeverityMinor);
}
catch (\Exception $ex) {
  $rethrow = $handler->handleException($ex,'hickups');
  $rethrow = $rethrow ? 'Yes' : 'No';
  $wasLogged = $logHandler->hasErrorRecords();

  print "Ex 3 was logged? $wasLogged, rethrow? $rethrow\n";
  // $this->assertTrue($logHandler->hasErrorRecords());
}

try {
  throw new \Tops\sys\TException("Error 3", \Tops\sys\TException::SeverityMinor);
}
catch (\Exception $ex) {
  $rethrow = $handler->handleException($ex,'snafus');
  $rethrow = $rethrow ? 'Yes' : 'No';
  $wasLogged = $logHandler->hasErrorRecords();

  print "Ex 4 was logged? $wasLogged, rethrow? $rethrow\n";
  // $this->assertTrue($logHandler->hasErrorRecords());
}

$records = $logHandler->getRecords();
print_r($records);
/*
foreach($records as $rec) {
  print $rec['message']."\n\n";
};
// var_dump($records);
*/