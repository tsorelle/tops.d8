<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 8:06 AM
 */

namespace Tops\sys;


class TYmlConfigManager implements IConfigManager {

    public function get($configName, $subSection = '')
    {
        $config = new TConfig();
        $config->loadConfig($configName, $subSection);
        return $config;
    }
}