<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/13/2015
 * Time: 7:07 AM
 */

namespace App\services;
use Tops\services;

class TestRestrictedServiceCommand extends \Tops\services\TServiceCommand {

    public function __construct() {
        $this->addAuthorization("test authorization");
    }

    protected function run()
    {
        $this->addInfoMessage("Processed request");
    }
}