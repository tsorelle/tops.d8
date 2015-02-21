<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/26/2015
 * Time: 10:21 AM
 */

namespace App\db;
use \Tops\db\TDbMailboxManager;
use Tops\sys\IMailboxManager;

class TScymMailboxManager extends TDbMailboxManager implements IMailboxManager {


    protected function getCodeColumn()
    {
        return 'box';
    }

    protected function getMailboxClassName()
    {
        return 'App\db\ScymMailbox';
    }

    protected function createMailboxEntity()
    {
        return new ScymMailbox();
    }
}