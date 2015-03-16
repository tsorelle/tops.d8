<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/15/2015
 * Time: 6:09 PM
 *
 * Autoload techniques:
 * To autoload tops and drupal core:
 *    require __DIR__.'/../Tops/start/autoload.php';
 *
 * To autoload tops, drupal and selected extensions such as tops module:
 *   $loader = require __DIR__.'/../Tops/start/autoload.php';
 *   Tops\test\TTestLoader::Create($loader,"tops");
 *
 * To autoload tops, drupal core and all Drupal Extensions:
 *    require_once __DIR__.'/../Tops/start/drupalAutoload.php';
 */


require_once __DIR__."/TTestLoader.php";

print "starting\n";

// autoload tops, drupal core and tops module
$loader = require __DIR__.'/../Tops/start/autoload.php';
Tops\test\TTestLoader::Create($loader,"tops");

print "loaded\n\n";
if (class_exists('Drupal\tops\Controller\TopsController')) {
    print "found it\n";
    if (class_exists('\Drupal\tops\sys\TDrupalTest')) {
        print "hooray\n";
        // \Drupal\tops\sys\TDrupalTest::speak();

    }
    else print "hiss!boo!\n";
}
else {
    print "foo!\n";
}

//

// \Drupal\tops\sys\TDrupalTest::speak();