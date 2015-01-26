<?php

namespace App\db;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mailboxes
 *
 * A doctrine entity object that maps the SCYM mailboxes table to the IMailBox interface.
 *
 * @Table(name="mailboxes", uniqueConstraints={@UniqueConstraint(name="boxIndex", columns={"box"})})
 * @Entity
 */
class ScymMailbox implements \Tops\sys\IMailBox
{
    /**
     * @var integer
     *
     * @Column(name="boxId", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $boxId;

    private $isNew;

    /**
     * @var string
     *
     * @Column(name="box", type="string", length=30, nullable=false)
     */
    private $box = '';

    /**
     * @var string
     *
     * @Column(name="address", type="string", length=100, nullable=true)
     */
    private $address;

    /**
     * @var string
     *
     * @Column(name="displayText", type="string", length=100, nullable=true)
     */
    private $displayText;

    /**
     * @var string
     *
     * @Column(name="description", type="string", length=100, nullable=true)
     */
    private $description;


    /**
     * Get mailBoxId
     *
     * @return integer 
     */
    public function getMailBoxId()
    {
        if ($this->isNew) {
            return 0;
        }
        return $this->boxId;
    }


    /**
     * Set box
     *
     * @param int $mailBoxId
     */
    public function setMailBoxId($mailBoxId) {
        if ($mailBoxId === 0) {
            $this->isNew = true;
        }
        else {
            $this->isNew = false;
            // ignore autoincrement field
        }
    }

    /**
     * Set box
     *
     * @param string $box
     * @return string
     */
    public function setMailboxCode($mailBoxCode)
    {
        $this->box = $mailBoxCode;

        return $this;
    }

    /**
     * Get box
     *
     * @return string 
     */
    public function getMailboxCode()
    {
        return $this->box;
    }

    /**
     * Set address
     *
     * @param string $email
     * @return string
     */
    public function setEmail($email)
    {
        $this->address = $email;

        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->address;
    }

    /**
     * Set displaytext
     *
     * @param string $displaytext
     * @return string
     */
    public function setName($name)
    {
        $this->displayText = $name;

        return $this;
    }

    /**
     * Get displaytext
     *
     * @return string 
     */
    public function getName()
    {
        return $this->displayText;
    }

    /**
     * Set displaytext
     *
     * @param string $displaytext
     * @return string
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

}
