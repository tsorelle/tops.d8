<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 8:06 AM
 */

namespace Tops\sys;


/**
 * Class TYmlConfigManager
 * @package Tops\sys
 * Class factory for Configuration objects using YML configuration files
 */
class TYmlConfigManager implements IConfigManager {

    /**
     * @inheritdoc
     */
    public function get($configName, $subSection = '')
    {
        $config = new TConfig();
        $config->loadConfig($configName, $subSection);
        return $config;
    }
}