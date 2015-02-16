<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/14/2015
 * Time: 10:59 AM
 */

namespace App\services;
use Tops\services;
use Tops\sys\TPostOffice;

class GetMailboxListCommand extends services\TServiceCommand {

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