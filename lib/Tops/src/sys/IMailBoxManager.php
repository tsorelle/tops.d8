<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/22/2015
 * Time: 2:34 PM
 */

namespace Tops\sys;


/**
 * Interface IMailBoxManager
 * @package Tops\sys
 */
interface IMailBoxManager {
    /**
     *
     * @param $id
     * @return IMailBox
     */
    public function find($id);

    /**
     * @param $id
     */
    public function drop($id);

    /**
     * @param $mailboxCode
     * @return IMailBox
     */
    public function findByCode($mailboxCode);

    /**
     * @return IMailBox
     */
    public function getMailboxes($filter = null);

    /**
     * @param $code
     * @param $name
     * @param $address
     * @param $description
     * @return IMailBox
     */
    public function addMailbox($code,$name,$address,$description);

    /**
     * @param IMailBox $mailbox
     * @return int
     */
    public function updateMailbox(IMailBox $mailbox);

    /**
     * @param $code
     * @param $name
     * @param $address
     * @param $description
     * @return IMailBox
     */
    public function createMailBox($code, $name, $address, $description);

}