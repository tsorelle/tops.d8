<?php
/**
 * Created by PhpStorm.
 * User: tsorelle
 * Date: 3/3/14
 * Time: 4:25 AM
 */
namespace Tops\drupal;

use Symfony\Component\HttpFoundation\Request;
use Tops\sys;
use Drupal;

class TViewModel
{
    private static $vmPaths = array();
    private static $vmname = null;

    public static function getVmName()
    {
        if (self::$vmname && array_key_exists(self::$vmname,self::$vmPaths)) {
            return self::$vmname;
        }
        return false;
    }

    public static function getNameFromRequest(Request $request)
    {
        $path = $request->getPathInfo();
        if ($path && $request->getMethod() == 'GET' && $request->getRequestFormat() == 'html') {
            $pathParts = explode('/', $path);
            $count = count($pathParts);
            if ($count < 2) {
                return null;
            }

            $name = $pathParts[1];
            $arg = '';
            if ($name == 'node') {
                if (!is_numeric($pathParts[2])) {
                    return null;
                }
                if ($count > 3) {
                    $arg = $pathParts[3];
                }
            } else {
                if ($count > 2) {
                    $arg = $pathParts[2];
                }
            }
            if ($arg == 'add' || $arg == 'edit') {
                return null;
            }

            if ($name == 'node') {
                $name = $name . '/' . $pathParts[2];
                return self::getAlias(Drupal::service('path.alias_manager'), $name);
            }
            return $name;
        }
        return null;
    }


    private static function getAlias(Drupal\Core\Path\AliasManager $aliasManager, $path)
    {
        return $aliasManager ?  $aliasManager->getAliasByPath($path) : null;
    }

    public static function getVmPath() {
        $name = self::$vmname;
        if ($name && array_key_exists($name,self::$vmPaths)) {
            return self::$vmPaths[$name];
        }
        return null;
    }

    public static function Initialize(Request $request) {
        $name = self::getNameFromRequest($request);
        if ($name)
        {
            $vmPath = "assets/js/Tops.App/$name".'ViewModel.js';
            $vmLocation = __DIR__.'/../../../../'.$vmPath;
            if (file_exists($vmLocation)) {
                self::$vmPaths[$name] = $vmPath;
                self::$vmname = $name;
                return true;
            }
            else if (array_key_exists($name,self::$vmPaths)) {
                unset(self::$vmPaths[$name]);
            }
        }
        return false;
    }

    private static function addScripts() {
        // assume jquery already added.
        // drupal_add_js("topsJS/jquery-1.8.3.js");
        // drupal_add_js("misc/jquery.js"); // must be  jquery-1.8.3.js or up
        // todo:update for 8
        /*
        drupal_add_js("topsJS/json2.js");
        drupal_add_js("topsJS/knockout-2.2.1.js");
        drupal_add_js("topsJS/Tops.Peanut/Peanut.js");
        drupal_add_js("topsJS/Tops.App/App.js");
        */
    }

    public static function RenderMessageElements() {
        if (self::getVmPath()) {
            return '<messages-component></messages-component>';
        }
        return '';
    }

    public static function RenderStartScript() {
        $vmPath = self::getVmPath();
        if ($vmPath)
        {
            return '<script src="'.$vmPath.'"'."></script>\n".
            "<script>\n".
            "   ViewModel.init('/');\n".
            "   ko.applyBindings(ViewModel);\n".
            "</script>\n";
        }
        return '';
    }
} 