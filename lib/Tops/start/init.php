<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 11/8/2014
 * Time: 6:02 PM
 */
$libPath = realpath(__DIR__."/../..");
require_once($libPath . "/Tops/src/sys/TClassPath.php");
\Tops\sys\TClassPath::Create($libPath);
\Tops\sys\TClassPath::Add('\App','App/src');
unset($libPath);


