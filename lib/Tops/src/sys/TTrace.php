<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 2/9/2015
 * Time: 11:00 AM
 */

namespace Tops\sys;


class TTrace {
    private $messages = array();
    private $echoMessage = false;
    private $suspended = array();
    private $traceId = array();
    private $traceCount = -1;
    private $outputMode = "html";

    /**
     * @var ILogger;
     */
    private $traceLogger = null;

    public function  __construct($outputMode = 'html', ILogger $logger = null)
    {
        $this->outputMode = $outputMode;
        $this->traceLogger = $logger;
    }


    public function active()
    {
        return  ($this->traceCount > -1 &&
            (!$this->suspended[$this->traceCount]));
    }

    public function addMessage($message)
    {

        if ($this->traceCount > -1) {
            if (!$this->suspended[$this->traceCount]) {
                $traceId = $this->traceId[$this->traceCount];
                if (!empty($traceId))
                    $message = "[$traceId] ".$message;
                array_push($this->messages,$message);
                if ($this->echoMessage)
                    echo
                    $this->outputMode == "html" ?
                        '<span style="background-color:white">Trace: '.$message.'</span><br/>' :
                        "$message\n";
            }
        }
    }  //  addMessage

    public function setEchoOn()
    {
        $this->echoMessage = true;
    }  //  echoOn

    public function setEchoOff()
    {
        $this->echoMessage = false;
    }  //  echoOff

    public function suspendTrace()
    {
        $this->suspended[$this->traceCount] = true;
    }  //  suspend

    public function resumeTrace()
    {
        $this->suspended[$this->traceCount] = false;
    }  //  resume

    public function resetTraces()
    {
        $this->messages = array();
        $this->suspended = array();
    }  //  reset

    public function startTrace($traceId = '')
    {
        array_push($this->traceId,$traceId);
        array_push($this->suspended,false);
        ++$this->traceCount;
    }  //  start

    public function stopTrace($traceId='')
    {
        if ($this->traceCount < 0)
            return; // already off
        if ($this->traceId[$this->traceCount] == $traceId) {
            array_pop($this->traceId);
            array_pop($this->suspended);
            --$this->traceCount;
        }
    }  //  end

    public function getTraceMessages()
    {
        return $this->messages;
    }  //  getMessages

}