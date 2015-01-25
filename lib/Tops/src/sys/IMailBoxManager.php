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
     * @return TMailBox
     */
    public function find($id);

    /**
     * @param $id
     */
    public function drop($id);

    /**
     * @param $mailboxCode
     * @return TMailBox
     */
    public function findByCode($mailboxCode);

    /**
     * @return TMailBox[]
     */
    public function getMailboxes($filter = null);

    /**
     * @param $code
     * @param $name
     * @param $address
     * @param $description
     * @return TMailBox
     */
    public function addMailbox($code,$name,$address,$description);

    /**
     * @param TMailBox $mailbox
     * @return int
     */
    public function updateMailbox(TMailBox $mailbox);

}