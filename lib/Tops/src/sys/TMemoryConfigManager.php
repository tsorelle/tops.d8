<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/19/2015
 * Time: 3:47 PM
 */

namespace Tops\sys;


class TMemoryConfigManager implements IConfigManager {

    private $configs;

    public function __construct() {
        $this->configs = Array();
    }

    public function addConfig($configName, $configData) {
        $configs[$configName] = $configData;
    }

    public function get($configName, $subSection = '')
    {
        $configData = $this->configs[$configName];

        $config = new TConfig();
        $config->setConfig($configData, $subSection);
        return $config;
    }
}