<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/18/2015
 * Time: 4:42 PM
 */

namespace Tops\sys;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class TObjectContainer {
    private static $container;

    public static function clear() {
        self::$container = null;
    }
    public static function getContainer() {
        if (!(self::$container)) {
            self::$container = new ContainerBuilder();
        }
        return self::$container;
    }

    /**
     * @param $key
     * @return mixed
     */
    public static function get($key) {
        return self::_get(self::getContainer(),$key);
    }

    private static function _get(ContainerBuilder $container,$key) {
        return $container->get($key);
    }

    public static function register($key,$className,$arguments = null) {
        return self::_register(self::getContainer(),$key,$className,$arguments);
    }

    private static function _register(ContainerBuilder $container, $key, $className, $arguments = null) {
        $definition = $container->register($key,$className);
        if ($arguments !== null) {
            if (!is_array($arguments)) {
                $definition->addArgument(New Reference($arguments));
            }
            else {
                foreach($arguments as $arg ) {
                    $definition->addArgument(New Reference($arg));
                }
            }
        }
        return $definition;
    }

    public static function loadConfig($fileName = null,$configLocation = null) {
        self::_loadConfig(self::getContainer(),$fileName,$configLocation);
    }

    private static function _loadConfig(ContainerBuilder $container, $fileName = null,$configLocation = null) {
        $loader = new YamlFileLoader($container, new TConfigFileLocator($configLocation));
        $loader->load($fileName);
    }



}