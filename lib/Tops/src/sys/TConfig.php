<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/26/2014
 * Time: 11:38 AM
 */

namespace Tops\sys;
use Symfony\Component\Yaml\Parser;


/**
 * Class TConfig
 * @package Tops\sys
 *
 * Stores and dispenses configuration data.
 * Source may be a YML file or array in memory.
 */
class TConfig extends TConfigSection implements IConfiguration {

    /**
     * @param $fileName
     * @param string $subSection
     *
     * Get config data from a YML configuration file.
     */
    public function loadConfig($fileName,$subSection = '') {
        $filePath = TPath::ConfigPath($fileName.'.yml');
        $yaml = new Parser();
        $raw = file_get_contents($filePath);
        $section = $yaml->parse($raw);
        if (!empty($subSection)) {
            $section = $this->getValue($subSection,$section);
        }
        $this->setConfig($section);
        // $this->configData = $section;
    }


}