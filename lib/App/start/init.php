<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/26/2015
 * Time: 7:36 AM
 */
// \Tops\sys\TObjectContainer::register('mailbox','\App\db\ScymMailbox');
\Tops\sys\TObjectContainer::register('mailboxManager','\App\db\TScymMailboxManager','configManager');
\Tops\sys\TObjectContainer::register('postOffice','\Tops\sys\TPostOffice',array('mailer','mailboxManager'));

// \Tops\sys\TObjectContainer::loadConfig('di.yml');
