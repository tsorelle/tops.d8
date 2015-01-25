<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/19/2015
 * Time: 3:47 PM
 */

namespace Tops\sys;


/**
 * Class TMemoryConfigManager
 * @package Tops\sys
 *
 * A class factory for TConfig with a memory config data source
 * Used for unit testing.
 */
class TMemoryConfigManager implements IConfigManager {

    /**
     * @var array
     */
    private $configs;

    public function __construct() {
        $this->configs = Array();
    }

    /**
     * @param $configName
     * @param $configData
     */
    public function addConfig($configName, $configData) {
        $configs[$configName] = $configData;
    }

    /**
     * @inheritdoc
     */
    public function get($configName, $subSection = '')
    {
        $configData = $this->configs[$configName];

        $config = new TConfig();
        $config->setConfig($configData, $subSection);
        return $config;
    }


    /**
     * @inheritdoc
     */
    public function getLocal($configName, $subSection = '')
    {
        return $this->get($configName,$subSection);
    }

    /**
     * Get name of local environment
     *
     * @return string
     */
    public function getEnvironment()
    {
        // TODO: Implement getEnvironment() method.
    }
}