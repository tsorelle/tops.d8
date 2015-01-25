<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 7:59 AM
 */

namespace Tops\sys;


interface IConfiguration {
    public function Value($key,$default=null);
}