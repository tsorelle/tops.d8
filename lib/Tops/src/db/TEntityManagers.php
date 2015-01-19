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


class TEntityManagers {
    private $managers;
    private $environment;
    private $configManager;

    private static $instance;

    public static function create(IConfigManager $configManager) {
        self::$instance = new TEntityManagers($configManager);
    }

    public function __construct(IConfigManager $configManager)
    {
        $this->configManager = $configManager;
        $topsConfig = $configManager->get("tops");
        $this->initialize($topsConfig);

    }

    private function initialize(IConfiguration $topsConfig) {
        $this->managers = Array();
        $this->environment = $topsConfig->Value("environment");

        if ($this->environment == null) {
            throw new \Exception("No tops.yml environment setting found.");
        }
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
        if (array_key_exists($key,$this->managers))
            return $this->managers[$key];

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
        $connectionsConfig = $this->configManager->get("connections-".$this->environment);
        $entityManager = $this->configureEntityManager($connectionsConfig,$databaseId,$entityPath,$isDevMode);
        $this->managers[$typeKey] = $entityManager;
        return $entityManager;
    }

    private function configureEntityManager(IConfiguration $connectionsConfig, $databaseId, $entityPath, $isDevMode)
    {
        $connectionParams = $connectionsConfig->Value($databaseId);
        $metaConfigPath = TPath::FromLib($entityPath);
        $metaConfig = Setup::createAnnotationMetadataConfiguration(array($metaConfigPath), $isDevMode);
        $entityManager = EntityManager::create($connectionParams,$metaConfig);
        return $entityManager;
    }


}