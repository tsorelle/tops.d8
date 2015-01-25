<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/22/2015
 * Time: 2:36 PM
 */

namespace Tops\sys;


/**
 * Class TMailBox
 * @package Tops\sys
 */
class TMailBox {
    /**
     * @var int
     */
    private $mailBoxId;
    /**
     * @var string
     */
    private $mailBoxCode;
    /**
     * @var string
     */
    private $name;

    /**
     * @return int
     */
    public function getMailBoxId()
    {
        return $this->mailBoxId;
    }

    /**
     * @param int $mailBoxId
     */
    public function setMailBoxId($mailBoxId)
    {
        $this->mailBoxId = $mailBoxId;
    }

    /**
     * @return string
     */
    public function getMailBoxCode()
    {
        return $this->mailBoxCode;
    }

    /**
     * @param string $mailBoxCode
     */
    public function setMailBoxCode($mailBoxCode)
    {
        $this->mailBoxCode = $mailBoxCode;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $description;

    /**
     * @param $code
     * @param $name
     * @param $address
     * @param $description
     * @return TMailBox
     */
    public static function Create ($code, $name, $address, $description) {
        $result = new TMailBox();
        $result->setMailBoxCode($code);
        $result->setEmail($address);
        $result->setDescription($description);
        $result->setName($name);
        return $result;
    }

}