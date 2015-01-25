<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/23/2015
 * Time: 3:02 PM
 */

namespace Tops\sys;

class TMemoryMailboxManager implements IMailBoxManager {

    /**
     * @var TMailBox[]
     */
    private $boxes;
    private $compareByIdCallBack;
    private $compareByCodeCallBack;


    public function __construct(array $boxes = null) {
        $this->boxes = new TCollection($boxes);
        $this->compareByIdCallBack = function (TMailBox $mailBox, $idValue) {
            return $mailBox->getMailBoxId() == $idValue;
        };
        $this->compareByCodeCallBack = function (TMailBox $mailBox, $code) {
            return $mailBox->getMailBoxCode() == $code;
        };
    }

    /**
     *
     * Use with unit test
     *
     * @param $id
     * @return TMailBox
     */
    public function find($id)
    {
        return $this->boxes->first($this->compareByIdCallBack, $id);
    }

    /**
     * @param $id
     */
    public function drop($id)
    {
        $this->boxes->removeItem($this->compareByIdCallBack,$id);
    }

    /**
     * @param $mailboxCode
     * @return TMailBox
     */
    public function findByCode($mailboxCode)
    {
        return $this->boxes->first($this->compareByCodeCallBack,$mailboxCode);
    }

    /**
     * @return TMailBox[]
     */
    public function getMailboxes($filter = null, $arguments = null)
    {
        if ($filter == null) {
            return $this->boxes->toArray();
        }
        $result = $this->boxes->filter($filter,$arguments);
        if ($result == null) {
            return null;
        }
        return $result->toArray();
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
        $box = TMailBox::Create($code,$name,$address,$description);
        $id = $this->boxes->getCount();
        $box->setMailBoxId($id);
        $this->boxes->add($box);
        return $box;
    }

    /**
     * @param TMailBox $mailbox
     * @return int
     */
    public function updateMailbox(TMailBox $mailbox)
    {
        if ($mailbox->getMailBoxId() < 1) {
            $this->boxes->add($mailbox);
        }
        else {
            $code = $mailbox->getMailBoxCode();
            $key = $this->boxes->findKey($this->compareByCodeCallBack, $code);
            if ($key == null) {
                return false;
            }
            $this->boxes->set($key,$mailbox);
        }
        return true;
    }

    public function getCount() {
        return $this->boxes->getCount();
    }
}