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
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class TObjectContainer
 * @package Tops\sys
 *
 * A facade for dependency injection using the Symfony 2 component
 */
class TObjectContainer {
    /**
     * @var ContainerBuilder
     */
    private static $container;

    /**
     *  Release container so a new one will be created on next get container call.
     *  Used primarily for unit tests.
     */
    public static function clear() {
        self::$container = null;
    }

    /**
     * @return ContainerBuilder
     *
     * Get container instance, create instance if null
     */
    public static function getContainer() {
        if (!(self::$container)) {
            self::$container = new ContainerBuilder();
        }
        return self::$container;
    }

    /**
     * @param $key
     * @return mixed
     *
     * Retrieve instance from the container.
     */
    public static function get($key) {
        return self::$container->get($key);
    }

    /**
     * @param $id
     * @return bool
     */
    public static function hasDefinition($id) {
        return self::getContainer()->hasDefinition($id);
    }

    /**
     * @param $key
     * @param $className
     * @param null $arguments
     * @return \Symfony\Component\DependencyInjection\Definition
     */
    public static function register($key,$className,$arguments = null) {
        $definition = self::getContainer()->register($key,$className);

        if ($arguments !== null) {
            if (!is_array($arguments)) {
                $args = explode(',',$arguments);
                $count = sizeof($args);
                for ($i = 0; $i< $count; $i++) {
                    self::addArgument($definition,$args[$i]);
                    // $definition->addArgument(New Reference($args[$i]));
                }
            }
            else {
                foreach($arguments as $arg ) {
                    self::addArgument($definition,$arg);
                    // $definition->addArgument(New Reference($arg));
                }
            }
        }
        return $definition;
    }

    private static function addArgument(Definition $definition, $arg)
    {
        if (empty($arg)) {
            return;
        }
        if (substr($arg,0,1) == ':') {
            $definition->addArgument(substr($arg,1));
        }
        else if (substr($arg,0,1) == '%') {
            $definition->addArgument($arg);
        }
        else {
            if (substr($arg,0,1) == '@') {
                $arg = substr($arg,1);
            }
            $definition->addArgument(New Reference($arg));
        }
    }

    public static function SetParameter($name, $value) {
        self::getContainer()->setParameter($name,$value);
    }


    /**
     * @param null $fileName
     * @param null $configLocation
     */
    public static function loadConfig($fileName = 'di.yml',$configLocation = null) {
/*
        if ($configLocation === null) {
            $configLocation = TPath::GetConfigRoot();
        }
*/
        $loader = new YamlFileLoader(self::$container, new TConfigFileLocator($configLocation));
        $loader->load($fileName);
    }




}