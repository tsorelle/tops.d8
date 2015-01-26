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
     * @var IMailBox
     */
    private $boxes;
    private $compareByIdCallBack;
    private $compareByCodeCallBack;


    public function __construct(array $boxes = null) {
        $this->boxes = new TCollection($boxes);
        $this->compareByIdCallBack = function (IMailBox $mailBox, $idValue) {
            return $mailBox->getMailBoxId() == $idValue;
        };
        $this->compareByCodeCallBack = function (IMailBox $mailBox, $code) {
            return $mailBox->getMailBoxCode() == $code;
        };
    }

    /**
     *
     * Use with unit test
     *
     * @param $id
     * @return IMailBox
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
     * @return IMailBox
     */
    public function findByCode($mailboxCode)
    {
        return $this->boxes->first($this->compareByCodeCallBack,$mailboxCode);
    }

    /**
     * @return IMailBox
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
     * @return IMailBox
     */
    public function addMailbox($code, $name, $address, $description)
    {
        $box = $this->createMailBox($code, $name, $address, $description);
        $id = $this->boxes->getCount();
        $box->setMailBoxId($id);
        $this->boxes->add($box);
        return $box;
    }

    /**
     * @inheritdoc
     */
    public function createMailBox($code, $name, $address, $description) {
        return TMailBox::Create($code,$name,$address,$description);
    }

    /**
     * @param IMailBox $mailbox
     * @return int
     */
    public function updateMailbox(IMailBox $mailbox)
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

    /**
     * @inheritdoc
     */
    public function getCount() {
        return $this->boxes->getCount();
    }
}