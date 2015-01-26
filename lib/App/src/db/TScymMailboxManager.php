<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/26/2015
 * Time: 10:21 AM
 */

namespace App\db;
use \Tops\db\TDbMailboxManager;

class TScymMailboxManager extends TDbMailboxManager implements \Tops\sys\IMailBoxManager {


    protected function getCodeColumn()
    {
        return 'box';
    }

    protected function getMailboxClassName()
    {
        return 'App\db\ScymMailbox';
    }

    protected function createMailBoxEntity()
    {
        return new ScymMailbox();
    }
}