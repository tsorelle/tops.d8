<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/19/2015
 * Time: 6:05 PM
 */
require_once __DIR__ . '/../../../core/vendor/autoload.php';
$libPath = realpath(__DIR__."/../..");
require_once($libPath . "/Tops/src/sys/TClassPath.php");
\Tops\sys\TClassPath::Create($libPath);
unset($libPath);

\Tops\sys\TClassPath::Add('\App','App/src');
\Tops\sys\TClassPath::Add('\Doctrine\ORM','vendor\doctrine\orm\lib\Doctrine\ORM');
\Tops\sys\TClassPath::Add('\Doctrine\DBAL','vendor\doctrine\dbal\lib\Doctrine\DBAL');
\Tops\sys\TClassPath::Add('\Symfony\Component','vendor/Symfony/Component');
