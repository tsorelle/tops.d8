<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/26/2015
 * Time: 7:36 AM
 */
\Tops\sys\TObjectContainer::register('mailboxManager','\App\db\TScymMailboxManager','configManager');
\Tops\sys\TObjectContainer::register('user','\Tops\drupal\TDrupalUser');

// \Tops\sys\TObjectContainer::LoadConfig('di.yml');
