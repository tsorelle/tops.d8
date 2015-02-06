<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/3/2015
 * Time: 11:46 AM
 */

require_once __DIR__ . '/../Tops/start/autoload.php';
require_once __DIR__ . '/../Tops/start/init.php';

use Tops\db\TEntityManagers;

if (!class_exists('\Doctrine\ORM\EntityManager',true)) {
    throw new \Exception("manager class not found");
}

\Tops\sys\TObjectContainer::clear();
\Tops\sys\TObjectContainer::register('configManager','\Tops\sys\TYmlConfigManager');

$emScym = TEntityManagers::Get('scym');
$repository = $emScym->getRepository('App\db\scym\ScymPerson');
$person = $repository->findOneBy(array('lastname' => 'SoRelle', 'firstname' => 'Terry'));
print "SCYM:\n";
print 'First: '.$person->getFirstName()."\n\n";
print 'Last: '.$person->getLastName()."\n\n";

$emFma = TEntityManagers::Get('fma');
$repository = $emFma->getRepository('App\db\fma\FmaPerson');
$person = $repository->findOneBy(array('lastname' => 'SoRelle', 'firstname' => 'Terry'));
print "FMA:\n\n";
print 'First: '.$person->getFirstName()."\n\n";
print 'Last: '.$person->getLastName()."\n\n";
