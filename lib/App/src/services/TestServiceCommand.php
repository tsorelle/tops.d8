<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/9/2015
 * Time: 2:18 PM
 */

namespace App\services;
use Tops\services;

class TestServiceCommand extends services\TServiceCommand
{

    protected function run()
    {
        $req = $this->getRequest();
        if ($req) {
            $req->testMessageText = "Processed";
            $this->setReturnValue($req);
            $this->addInfoMessage("Processed request");
        }
        else {
            $this->addErrorMessage('Expected as request');
        }
    }
}