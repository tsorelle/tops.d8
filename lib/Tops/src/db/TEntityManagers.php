<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 12/27/2014
 * Time: 8:45 AM
 */

namespace Tops\db;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Tops\sys\IConfigManager;
use Tops\sys\IConfiguration;
use Tops\sys\TObjectContainer;
use Tops\sys\TPath;


/**
 * Class TEntityManagers
 * @package Tops\db
 *
 * Class factory for Doctrine ORM EntityManager
 */
class TEntityManagers {
    private $entityMananagers;
    private $environment;
    private $configManager;

    private static $instance;

    public static function create(IConfigManager $configManager) {
        self::$instance = new TEntityManagers($configManager);
    }

    public function __construct(IConfigManager $configManager)
    {
        $this->environment = $configManager->getEnvironment();
        $this->entityMananagers = Array();
        $this->configManager = $configManager;

    }

    /**
     * Get a Doctrine entity manager based on name of database type.
     *
     * @param string $key  - name of database type
     * @return EntityManager
     * @throws \Exception
     */
    public static function Get($key='application')
    {
        if (!isset(self::$instance)) {
            $configManager = TObjectContainer::get("configManager");
            self::$instance = new TEntityManagers($configManager);
        }
        return self::$instance->_get($key);
    }

    public function _get($key)
    {
        if (array_key_exists($key,$this->entityMananagers))
            return $this->entityMananagers[$key];

        $config = $this->configManager->get("appsettings");
        return $this->createManager($config, $key);
    }


    /**
     * Build and initialize a Doctrine ORM entity manager based on database type key
     *
     * @param $typeKey
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    private function createManager(IConfiguration $dbConfig, $typeKey,$isDevMode=null) {
        $databaseId = $dbConfig->Value("databases/type/$typeKey");
        if ($isDevMode === null) {
            $isDevMode = $this->environment == "development";
        }
        $entityPath = $dbConfig->Value("databases/models/$databaseId");
        $connectionsConfig = $this->configManager->getLocal("appsettings","connections");
        $entityManager = $this->configureEntityManager($connectionsConfig,$databaseId,$entityPath,$isDevMode);
        $this->entityMananagers[$typeKey] = $entityManager;
        return $entityManager;
    }

    /**
     * @param IConfiguration $connectionsConfig
     * @param $databaseId
     * @param $entityPath
     * @param $isDevMode
     * @return EntityManager
     * @throws \Doctrine\ORM\ORMException
     */
    private function configureEntityManager(IConfiguration $connectionsConfig, $databaseId, $entityPath, $isDevMode)
    {
        $connectionParams = $connectionsConfig->Value($databaseId);
        $metaConfigPath = TPath::FromLib($entityPath);
        $metaConfig = Setup::createAnnotationMetadataConfiguration(array($metaConfigPath), $isDevMode);
        $entityManager = EntityManager::create($connectionParams,$metaConfig);
        return $entityManager;
    }


}