<?php
/**
 * Created by PhpStorm.
 * User: tsorelle
 * Date: 2/25/14
 * Time: 3:13 PM
 */

namespace Tops\services;

abstract class TServiceCommand {
    private  $context;
    private  $request;


    abstract protected function run();

    /**
     * Performs type cast on class variable $context.
     *
     * @param TServiceContext $result
     * @return TServiceContext
     */
    protected function getContext(TServiceContext $result = null)
    {
        if ($result === null) {
            $result = $this->context;
        }
        return $result;
    }

    protected function AddErrorMessage($text) {
        $context = $this->getContext();
        $context->AddErrorMessage($text);
    }

    public function AddInfoMessage($text) {
        $context = $this->getContext();
        $context->AddInfoMessage($text);
    }

    public function AddWarningMessage($text) {
        $context = $this->getContext();
        $context->AddWarningMessage($text);
    }

    public function SetReturnValue($value) {
        $context = $this->getContext();
        $context->SetReturnValue($value);
    }

    public function GetRequest() {

        return $this->request;
    }

    public function IsAuthorized() {
        return true;
    }

    public function Execute($request) {
        $this->context = new TServiceContext();
        $this->request = $request;
        if ($this->IsAuthorized())
            $this->run();
        else
            $this->AddErrorMessage("Sorry, you are not authorized to use this service.");
        return $this->context->GetResponse();
    }
}
