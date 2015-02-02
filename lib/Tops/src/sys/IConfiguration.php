<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 7:59 AM
 */

namespace Tops\sys;


interface IConfiguration {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    public function Value($key,$default=null);

    /**
     * @param $sectionPath
     * @param bool $default
     * @return boolean
     */
    public function IsTrue($sectionPath);

    /**
     * @param $sectionPath
     * @return IConfiguration
     */
    public function GetSection($sectionPath);
}