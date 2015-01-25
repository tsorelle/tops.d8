<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/23/2015
 * Time: 2:56 PM
 */

namespace Tops\sys;


/**
 * Manages email operations
 * Class TPostOffice
 * @package Tops\sys
 */
class TPostOffice {
    /**
     * @var IMailer
     */
    private $mailer;
    /**
     * @var IMailBoxManager
     */
    private $mailboxes;
    public function __construct(IMailer $mailer, IMailBoxManager $mailboxes) {
        $this->mailboxes = $mailboxes;
        $this->mailer = $mailer;
    }
}