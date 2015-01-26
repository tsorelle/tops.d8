<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/26/2015
 * Time: 7:04 AM
 */
namespace Tops\sys;


/**
 * Class TMailBox
 * @package Tops\sys
 */
interface IMailBox
{
    /**
     * @return int
     */
    public function getMailBoxId();

    /**
     * @param int $mailBoxId
     */
    public function setMailBoxId($mailBoxId);

    /**
     * @return string
     */
    public function getMailBoxCode();

    /**
     * @param string $mailBoxCode
     */
    public function setMailBoxCode($mailBoxCode);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getDescription();

    /**
     * @param string $description
     */
    public function setDescription($description);
}