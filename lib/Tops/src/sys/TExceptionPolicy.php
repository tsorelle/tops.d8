<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/1/2015
 * Time: 7:18 AM
 */

namespace Tops\sys;


class TExceptionPolicy {
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
     * @return boolean
     */
    public function setRethrow()
    {
        return $this->rethrow;
    }

    /**
     * @param boolean $rethrow
     */
    public function getRethrow($rethrow)
    {
        $this->rethrow = $rethrow;
    }

    /**
     * @return string
     */
    public function getLogName()
    {
        return $this->logName;
    }

    /**
     * @param string $logName
     */
    public function setLogName($logName)
    {
        $this->logName = $logName;
    }

    /**
     * @return int
     */
    public function getSeverity()
    {
        return $this->Severity;
    }

    /**
     * @param int $Severity
     */
    public function setSeverity($Severity)
    {
        $this->Severity = $Severity;
    }

    /**
     * @var string
     */
    private $name;
    /**
     * @var boolean
     */
    private $rethrow;
    /**
     * @var string
     */
    private $logName;
    /**
     * @var int
     */
    private $Severity;
}