<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/23/2015
 * Time: 3:01 PM
 */

namespace Tops\sys;


class TConfigMailboxManager implements IMailBoxManager {

    /**
     *
     * @param $id
     * @return TMailBox
     */
    public function find($id)
    {
        // TODO: Implement find() method.
    }

    /**
     * @param $id
     */
    public function drop($id)
    {
        // TODO: Implement drop() method.
    }

    /**
     * @param $mailboxCode
     * @return TMailBox
     */
    public function findByCode($mailboxCode)
    {
        // TODO: Implement findByCode() method.
    }

    /**
     * @return TMailBox[]
     */
    public function getMailboxes($filter = null)
    {
        // TODO: Implement getMailboxes() method.
    }

    /**
     * @param $code
     * @param $name
     * @param $address
     * @param $description
     * @return TMailBox
     */
    public function addMailbox($code, $name, $address, $description)
    {
        // TODO: Implement addMailbox() method.
    }

    /**
     * @param TMailBox $mailbox
     * @return int
     */
    public function updateMailbox(TMailBox $mailbox)
    {
        // TODO: Implement updateMailbox() method.
    }
}