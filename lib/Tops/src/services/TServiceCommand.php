<?php
/**
 * Created by PhpStorm.
 * User: tsorelle
 * Date: 2/25/14
 * Time: 3:13 PM
 */

namespace Tops\services;
use Tops\sys\IUser;
use Tops\sys\TUser;

/**
 * Class TServiceCommand
 * @package Tops\services
 */
abstract class TServiceCommand {
    /**
     * @var TServiceContext
     */
    private  $context;
    
    private  $request;

    /**
     * @var array
     */
    private $authorizations = array();

    abstract protected function run();

    protected function AddErrorMessage($text) {
        $this->context->AddErrorMessage($text);
    }

    public function AddInfoMessage($text) {
        $this->context->AddInfoMessage($text);
    }

    public function AddWarningMessage($text) {
        $this->context->AddWarningMessage($text);
    }

    public function SetReturnValue($value) {
        $this->context->SetReturnValue($value);
    }

    public function GetRequest() {

        return $this->request;
    }

    /**
     * @var IUser
     */
    private $user;

    /**
     * @return IUser
     */
    protected function getUser() {
        if (!isset($this->user)) {
            $this->user = TUser::getCurrent();
        }
        return $this->user;
    }


    public function IsAuthorized() {
        if (empty($this->authorizations))
            return true;
        $user = $this->getUser();
        foreach($this->authorizations as $auth) {
            if ($user->isAuthorized($auth)) {
                return true;
            }
        }
        return false;
    }

    protected function addAuthorization($authorization) {
        if (!in_array($authorization, $this->authorizations)) {
            array_push($this->authorizations, $authorization);
        }
    }


    /**
     * @param $request
     * @return TServiceResponse
     */
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
