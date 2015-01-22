<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/22/2015
 * Time: 8:26 AM
 */

namespace App\services;
use Tops\services;

class TTestGetServiceCommand extends \Tops\services\TServiceCommand {

    protected function run()
    {
        $id = $this->GetRequest();
        if (!$id) {
            $this->AddErrorMessage('Expected request');
        }
        if ($id == 3) {
            $this->AddInfoMessage("Found item");
            $item = new \stdClass();
            $item->name = "TestItem";
            $item->id = 3;
            $this->SetReturnValue($item);
        }
        else {
            $this->AddWarningMessage("id not found");
        }

    }
}