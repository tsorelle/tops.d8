<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/31/2014
 * Time: 7:54 AM
 */
require_once(__DIR__.'/../Tops/start/autoload.php');
require_once(__DIR__.'/../Tops/start/init.php');
require_once(__DIR__.'/../App/start/init.php');


$mgr = new \App\test\TestMailBoxManager();

$b1 = $mgr->findByCode('ADMIN');
if(!$b1)
   $mgr->addMailbox('ADMIN','Terry SoRelle','tls@2quakers.net','Administrator address');
$b2 = $mgr->findByCode('LIZ');
if(!$b2)
    $mgr->addMailbox('LIZ','Elizabeth Yeats','liz@2quakers.net','Liz address');
$mgr->saveChanges();

$mgr = new \App\test\TestMailBoxManager();


// use for ad hoc tests

print "\nDone.\n";

