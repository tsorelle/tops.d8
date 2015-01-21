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
     * @param $key
     * @param $className
     * @param null $arguments
     * @return \Symfony\Component\DependencyInjection\Definition
     */
    public static function register($key,$className,$arguments = null) {
        $definition = self::getContainer()->register($key,$className);
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


    /**
     * @param null $fileName
     * @param null $configLocation
     */
    public static function loadConfig($fileName = null,$configLocation = null) {
        $loader = new YamlFileLoader(self::$container, new TConfigFileLocator($configLocation));
        $loader->load($fileName);

    }




}