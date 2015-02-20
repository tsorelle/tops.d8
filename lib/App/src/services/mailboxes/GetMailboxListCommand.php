<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/14/2015
 * Time: 10:59 AM
 */

namespace App\services\mailboxes;
use Tops\services;
use Tops\services\TServiceCommand;
use Tops\sys\TPostOffice;

class GetMailboxListCommand extends TServiceCommand {

    protected function run()
    {
        $mgr = TPostOffice::GetMailboxManager();
        $result = $mgr->getMailboxes();
        $this->setReturnValue($result);
        $count = sizeof($result);
        if ($count) {
            $this->addInfoMessage("Found $count mailboxes.");
        } else {
            $this->addWarningMessage("No mailboxes found.");
        }

    }
}