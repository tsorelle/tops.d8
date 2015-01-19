<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 7:58 AM
 */

namespace Tops\sys;


interface IConfigManager {
    public function get($configName, $subSection = '');
}