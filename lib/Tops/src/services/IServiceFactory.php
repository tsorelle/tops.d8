<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/9/2015
 * Time: 1:15 PM
 */
namespace Tops\services;

interface IServiceFactory {
    public function CreateService($serviceId);
}