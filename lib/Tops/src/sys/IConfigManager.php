<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 7:58 AM
 */

namespace Tops\sys;


/**
 * Interface IConfigManager
 * @package Tops\sys
 */
interface IConfigManager {
    /**
     * @param $configName
     * @param string $subSection
     * @return IConfiguration
     */
    public function get($configName, $subSection = '');
}