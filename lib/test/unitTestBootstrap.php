<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/10/2015
 * Time: 6:24 AM
 */
require_once __DIR__ . '/../../core/vendor/autoload.php';
include(__DIR__ . "/../Tops/start/init.php");
\Tops\sys\TClassPath::Add('\Doctrine\ORM','vendor\doctrine\orm\lib\Doctrine\ORM');
\Tops\sys\TClassPath::Add('\Doctrine\DBAL','vendor\doctrine\dbal\lib\Doctrine\DBAL');
\Tops\sys\TClassPath::Add('\App','App/src');

