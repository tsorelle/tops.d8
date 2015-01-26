<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/23/2015
 * Time: 3:00 PM
 */

namespace Tops\db;
use \Tops\sys\IMailBoxManager;
use \Tops\sys\IMailBox;


abstract class TDbMailboxManager implements IMailBoxManager {

    /**
     * @return \Doctrine\ORM\EntityRepository The repository class.
     */
    private $repository;

    /**
     * @return \Doctrine\ORM\EntityManager The repository class.
     */
    private $entityManager;

    /**
     * @return \Doctrine\ORM\EntityManager The repository class.
     */
    private function getEntityManager() {
        if (!(isset($this->entityManager))) {
            $this->entityManager = TEntityManagers::Get();
        }
        return $this->entityManager;
    }

    /**
     * @return \Doctrine\ORM\EntityRepository The repository class.
     */
    private function getRepository() {
        if ($this->repository == null) {
            $em = TEntityManagers::Get();
            $this->repository = $em->getRepository($this->getMailboxClassName());
        }
        return $this->repository;
    }

    /**
     * @return string
     */
    protected abstract function getCodeColumn();
    /**
     * @return string
     */
    protected abstract function getMailboxClassName();

    /**
     *
     * @param $id
     * @return IMailBox
     */
    public function find($id)
    {
        $repository = $this->getRepository();
        return $repository->find($id);
    }

    /**
     * @param $id
     */
    public function drop($id)
    {
        $current = $this->find($id);
        if ($current == null) {
            return;
        }
        $em = $this->getEntityManager();
        $em->remove($current);
        $em->flush();
    }

    /**
     * @param $mailboxCode
     * @return IMailBox
     */
    public function findByCode($mailboxCode)
    {
        $repository = $this->getRepository();
        $columnName = $this->getCodeColumn();

        return $repository->findOneBy(array($columnName => $mailboxCode));

    }

    /**
     * @return IMailBox
     */
    public function getMailboxes($filter = null)
    {
        $repository = $this->getRepository();
        $repository->findAll();
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
        $newBox = $this->createMailBox($code, $name, $address, $description);
        $em = $this->getEntityManager();
        $em->persist($newBox);
        $em->flush();

        return $newBox;

    }

    /**
     * @param IMailBox $mailbox
     * @return int
     */
    public function updateMailbox(IMailBox $mailbox)
    {
        $current = null;
        $em = $this->getEntityManager();
        if ($mailbox->getMailBoxId() > 0) {
            $current = $this->find($mailbox->getMailBoxId());
        }

        if ($current == null) {
            $em->persist($mailbox);
        }
        else {
            $current->setDescription($mailbox->getDescription());
            $current->setMailBoxCode($mailbox->getMailBoxCode());
            $current->setName($mailbox->getName());
            $current->setDescription($mailbox->getDescription());
            $current->setEmail($mailbox->getEmail());
        }

        $em->flush();
    }


    /**
     * @param $code
     * @param $name
     * @param $address
     * @param $description
     * @return IMailBox
     */
    public function createMailBox($code, $name, $address, $description) {
        $result = $this->createMailBoxEntity();
        $result->setMailBoxCode($code);
        $result->setEmail($address);
        $result->setDescription($description);
        $result->setName($name);
        return $result;
    }

    /**
     * @return IMailbox
     */
    protected abstract function createMailBoxEntity();
}