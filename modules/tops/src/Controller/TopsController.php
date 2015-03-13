<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 3/13/2015
 * Time: 7:17 AM
 */
namespace Drupal\tops\Controller;

use Drupal\Core\Controller\ControllerBase;

use MyProject\Proxies\__CG__\stdClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tops\services\TServiceHost;


class TopsController extends ControllerBase {

    public function executeService(Request $request, $serviceCode) {
        $result = TServiceHost::ExecuteRequest($request, $serviceCode);
        return new JsonResponse($result);
    }

    public function getFromService(Request $request, $serviceCode,$serviceRequest) {
        $result = TServiceHost::ExecuteRequest($request, $serviceCode, $serviceRequest);
        return new JsonResponse($result);

    }

}
