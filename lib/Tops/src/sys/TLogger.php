<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/29/2015
 * Time: 7:57 AM
 */

namespace Tops\sys;
use Monolog\Handler\ChromePHPHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\TestHandler;
use Monolog\Logger;

/**
 * Class TLogger
 * @package Tops\sys
 */
class TLogger implements ILogger
{
    /**
     * @var array
     */
    private $logs;

    /**
     * @param IConfigManager $configManager
     * @param IMailer $mailer
     */
    public function __construct(IConfigManager $configManager = null, IMailer $mailer = null) {
        $this->logs = array();
        $loggingConfig = null;
        if ($configManager != null) {
            $config = $configManager->getLocal("appsettings","logging");
            $loggingConfig = $config->Value("logs");
        }

        if (!empty($loggingConfig)) {
            foreach ($loggingConfig as $section) {
                $logConfig = new TConfigSection($section);
                $logName = $logConfig->Value("name",'default');
                $handlers = $logConfig->Value("handlers",array());
                $log = new Logger($logName);
                $isDefault = $logConfig->IsTrue('default');
                foreach ($handlers as $handlerElement) {
                    $handlerConfig = new TConfigSection($handlerElement);
                    // $type = $handlerConfig->Value('type','default');
                    $handler = $this->createHandler($logName, $handlerConfig, $mailer);
                    $log->pushHandler($handler);
                }
                $this->logs[$logName] = $log;
                if ($isDefault) {
                    $this->logs['default'] = $log;
                }
            }
        }

        if (!array_key_exists('default',$this->logs)) {
            // set a default logger
            $log = new Logger('default');
            $log->pushHandler(
                new ErrorLogHandler()
            );

            $this->logs['default'] = $log;
        }
    }

    /**
     * @param $name
     * @param Logger $logger
     */
    public function setLog($name, Logger $logger)
    {
        $this->logs[$name] = $logger;
    }

    /**
     * @param $levelName
     * @return int
     */
    private function levelNameToLevel($levelName) {
        switch ($levelName) {
            // 100 => 'DEBUG',
            case 'debug' :
                return Logger::DEBUG;
            // 200 => 'INFO',
            case 'info':
                return Logger::INFO;
            // 250 => 'NOTICE',
            case 'notice' :
                return Logger::NOTICE;
            // 300 => 'WARNING',
            case 'warning' :
                return Logger::WARNING;
            // 400 => 'ERROR',
            case 'error' :
                return Logger::ERROR;
            // 500 => 'CRITICAL',
            case 'critical' :
                return Logger::CRITICAL;
            // 550 => 'ALERT',
            case 'alert' :
                return Logger::ALERT;
            // 600 => 'EMERGENCY',
            case 'emergency' :
                return Logger::EMERGENCY;
            default:
                return LOGGER::DEBUG;
        }
    }

    /**
     * @param array $handlerConfig
     * @param IMailer $mailer
     * @return \Monolog\Handler\HandlerInterface
     */
    private function createHandler($logName, IConfiguration $handlerConfig, IMailer $mailer)
    {
        $level = $this->levelNameToLevel($handlerConfig->Value('level','error'));
        $type = $handlerConfig->Value("type");
        $recipient = $handlerConfig->Value('recipient');
        $sender = $handlerConfig->Value('sender');
        if ($type == 'email' && ($mailer == null || empty($recipient) || empty($sender))) {
            //insufficient configuration for email.
            $type = 'default';
        }

        $bubble = $handlerConfig->IsTrue("bubble",false);
        $expandNewlines = $handlerConfig->IsTrue('expandlines',true);

        $filePath = $handlerConfig->Value('filepath');
        if (!empty($filePath)&& $filePath[0] == '~') {
            $filePath = TPath::FromRoot($filePath);
        }
        $maxFiles = $handlerConfig->Value('maxfiles');
        $permissions = $handlerConfig->Value('filepermissions');
        $uselocking = $handlerConfig->IsTrue('filelocking');

        switch ($type) {
            case 'errorlog' :
                return new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM,$level,$bubble,$expandNewlines);
            case 'email' :
                $handler = new \Tops\sys\TMailLogHandler($mailer, $sender, $recipient, $level,$bubble);
                return $handler;
            case 'testlog' :
                return new TestHandler($level,$bubble);
            case 'chromelog' :
                return new ChromePHPHandler($level,$bubble);
            case 'streamlog' :
                return new StreamHandler($filePath,$level,$bubble,$permissions,$uselocking);
            case 'rotatinglog' :
                return new RotatingFileHandler($filePath, empty($maxFiles) ? 0 : $maxFiles, $level,$bubble,
                    $permissions,empty($uselocking));
            default :
                return new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM,$level,$bubble,$expandNewlines);
        }
    }

    /**
     * @param $name
     * @return Logger
     */
    public function getLog($name)
    {
        if (array_key_exists($name, $this->logs)) {
            return $this->logs[$name];
        }
        return $this->logs['default'];
    }

    /**
     * @inheritdoc
     */
    public function write($message, $level = Logger::ERROR, $logName = 'default') {
        $log = $this->getLog($logName);
        $log->addRecord($level,$message);
    }

    /**
     * @inheritdoc
     */
    public function writeError($message, $logName = 'default') {
        $this->write($message, Logger::ERROR, $logName);
    }

    /**
     * @inheritdoc
     */
    public function writeWarning($message, $logName = 'default') {
        $this->write($message, Logger::WARNING, $logName);

    }

    /**
     * @inheritdoc
     */
    public function writeInfo($message, $logName = 'default') {
        $this->write($message, Logger::INFO, $logName);
    }
    
}