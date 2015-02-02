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

    private static $environment;

    /**
     * @inheritdoc
     */
    public function get($configName, $subSection = '')
    {
        $config = new TConfig();
        $config->loadConfig($configName, $subSection);
        return $config;
    }

    /**
     * @inheritdoc
     */
    public function getLocal($configName, $subSection = '') {
        $environment = $this->getEnvironment();
        return $this->get($configName.'-'.$environment,$subSection);
    }

    /**
     * @inheritdoc
     */
    public function getEnvironment()
    {
        if (!isset(self::$environment)) {
            $siteConfig = $this->get("sitesettings");
            self::$environment = $siteConfig->Value("environment");
            if (self::$environment == null) {
                throw new \Exception("No tops.yml environment setting found.");
            }
        }

        return self::$environment;

    }

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function Value($key, $default = null)
    {
        // TODO: Implement Value() method.
    }

    /**
     * @param $sectionPath
     * @param bool $default
     * @return boolean
     */
    public function IsTrue($sectionPath)
    {
        // TODO: Implement IsTrue() method.
    }

    /**
     * @param $sectionPath
     * @return IConfiguration
     */
    public function GetSection($sectionPath)
    {
        // TODO: Implement GetSection() method.
    }
}