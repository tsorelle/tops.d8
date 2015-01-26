<?php
/**
 * Initialize dependency injection.
 *
 * Created by PhpStorm.
 * User: Terry
 * Date: 11/8/2014
 * Time: 6:02 PM
 */
\Tops\sys\TObjectContainer::register('configManager','\Tops\sys\TYmlConfigManager');
\Tops\sys\TObjectContainer::register('serviceFactory','\Tops\services\TServiceFactory','configManager');
\Tops\sys\TObjectContainer::register('serviceHost','\Tops\services\TServiceHost','serviceFactory');

// Application specific objects should be registered in /App/start/init.php (or corresponding directory)
// e.g.
/*
     \Tops\sys\TObjectContainer::register('mailbox','\App\db\ScymMailbox');
     \Tops\sys\TObjectContainer::loadConfig('di.yml');
*/

