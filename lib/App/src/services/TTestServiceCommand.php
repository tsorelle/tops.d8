<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/9/2015
 * Time: 2:18 PM
 */

namespace App\services;
use Tops\services;

class TTestServiceCommand extends \Tops\services\TServiceCommand {

    protected function run()
    {
        $req = $this->GetRequest();
        $req->testMessageText = "Processed";
        $this->SetReturnValue($req);
    }
}