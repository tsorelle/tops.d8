<?php

namespace Tops\sys;

class TTracer
{

    /**
     * @var TTracer
     */
    private static $tracer;


    /**
     * @var ILogger;
     */
    private $traceLogger = null;
    private $flags = array();

    private $enabled;
    private $loggingEnabled;
    public function isEnabled() {
        return $this->enabled;
    }

    public function __construct(IConfigManager $configManager, ILogger $traceLogger = null) {

        $traceSection = $configManager->getLocal("appsettings","trace");
        $this->enabled = $traceSection->isTrue("active",false);
        $this->loggingEnabled = $traceSection->isTrue("logging",false);
        if ($traceLogger !== null && $this->loggingEnabled) {
            $defaultLog = $traceSection->Value('log', null);
            if (!empty($defaultLog)) {
                $traceLogger->setDefaultLogName($defaultLog);
            }
        }
        $this->traceLogger = $traceLogger;
        if ($this->enabled) {
            $this->flags =  $traceSection->GetSection('flags');
            $this->outputMode = array_key_exists('REQUEST_METHOD', $_SERVER) ? "html" : "console";
        }
    }
    
    // static


    private static function getOutputMode() {
        return array_key_exists('REQUEST_METHOD', $_SERVER) ? 'html' : 'console';
    }

    public static function WriteLine($value) {
        if (self::getOutputMode() == "html")
            print "$value<br>";
        else
            print "$value\n";
    }


    public static function On($traceId='')
    {
        if (!isset(self::$tracer)) {
            if (TObjectContainer::hasDefinition("tracer")) {
                self::$tracer = TObjectContainer::get("tracer");
            }
            else {
                self::$tracer = null;
                return;
            }
        }
        
        self::$tracer->_on($traceId);


    }  //  self::On

    private function _on($traceId) {
        $enabled = empty($traceId) || $this->flags->isTrue($traceId); 
        if ($enabled) {
            $this->startTrace($traceId);
        }
        else {
            $this->suspendTrace();
        }
    }

    public static function Off($traceId='')
    {
       self::$tracer->stopTrace($traceId);
    }  //  traceOff
    
        public static function Suspend()
        {
                self::$tracer->suspendTrace();
        }  //  self::Suspend()
    
        public static function Resume()
        {
                self::$tracer->resumeTrace();
        }  //  resumeTrace
    
        public static function Assert($value,$trueMessage,$falseMessage='',$file='',$line=0) {
            if (empty($value)) {
                if (empty($falseMessage))
                    $falseMessage = 'NOT: '.$trueMessage;
                self::Trace($falseMessage,$file,$line);
            }
            else
                self::Trace($trueMessage,$file,$line);
        }
    
        public static function Trace($message,$file='',$line=0)
        {
            if (self::$tracer->isEnabled()) {
                if (!empty($file)) {
                    if (!empty($line))
                        $message .= "  on line $line";
                    $message .= " in file '$file'.";
                }
                self::$tracer->addMessage($message);
            }

        }  //  trace


        public static function WriteLines()
        {
            $messages = self::GetMessages();
            $count = count($messages);
            if ($count == 0)
                return '';
            $result = $count.' trace messages\n';
            foreach ($messages as $message)
                $result .= "$message\n";
            return $result;
        }  //  dumpTrace
    
    
        public static function Render()
        {
            $messages = self::GetMessages();
            $br = self::getOutputMode() === 'html' ? '<br>' : '' ;
            $count = count($messages);
            if ($count == 0)
                return '';
            $result = $count." trace messages$br\n";
            foreach ($messages as $message)
                $result .= "$message$br\n";
            return $result;
        }  //  dumpTrace
    
        public static function PrintMessages() {
            $messageText = self::Render();
            if (!empty($messageText)) {
                if (self::getOutputMode() == 'html')
                    print '<div id="trace">' . $messageText . '</div>';
                else
                    print "$messageText\n";
            }
        }
    
        public static function GetMessages()
        {
            if (self::$tracer->isEnabled())
                return self::$tracer->getTraceMessages();
            return array();
        }  //  getTraceMessages
    
        public static function EchoOn()
        {
            if (self::$tracer->isEnabled())
                self::$tracer->setEchoOn();
        }  //  self::EchoOn
    
        public static function EchoOff()
        {
            if (self::$tracer->isEnabled())
                self::$tracer->setEchoOff();
        }  //  self::EchoOff
    
    
    
        public static function ShowArray($arr) {
            if (isset(self::$tracer) && self::$tracer->active()) {
                if (self::GetOutputMode() != "html") {
                    print "\n";
                    print_r($arr);
                    print "\n";
                }
                else {
                    print '<div style="padding:3px;background-color:white;color:black;text-align:left">';
                    print '<pre>';
                    print_r($arr);
                    print '</pre></div>';
                }
            }
        }

    // private

    private $messages = array();
    private $echoMessage = false;
    private $suspended = array();
    private $traceId = array();
    private $traceCount = -1;

    /**
     * @var ILogger;
     */
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
                    $message = "[$traceId] " . $message;
                array_push($this->messages, $message);

                if ($this->loggingEnabled) {
                    $this->traceLogger->writeInfo($message);
                }

                if ($this->echoMessage) {
                    $outputMode = self::getOutputMode();
                    echo
                    $outputMode == "html" ?
                        '<span style="background-color:white">Trace: ' . $message . '</span><br/>' :
                        "$message\n";
                }
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
        if ($this->enabled) {
            $this->suspended[$this->traceCount] = true;
        }
    }  //  suspend

    public function resumeTrace()
    {
        if ($this->enabled)
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
        if (!$this->enabled) {
            return;
        }
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


} // end TTracer
