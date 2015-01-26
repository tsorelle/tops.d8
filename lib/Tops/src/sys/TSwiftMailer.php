<?php
/**
 * Created by PhpStorm.
 * User: Terry
 * Date: 1/22/2015
 * Time: 3:05 PM
 */

namespace Tops\sys;


/**
 * Class TSwiftMailer
 * @package Tops\sys
 *
 * @see http://swiftmailer.org/docs  SwiftMailer
 */
class TSwiftMailer implements IMailer {

    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * SwiftMailer reference may be used to leverage SwiftMailer features not exposed by TMailMessage
     * such as file attachments.
     *
     * @return \Swift_Mailer
     */
    public  function getSwiftMailer()
    {
        return $this->swiftMailer;
    }

    public function __construct(IConfigManager $configManager) {
        $transport = new \Swift_SmtpTransport();
            // \Swift_SmtpTransport::newInstance();  NOTE: This SwiftMailer method define the wrong return type in PHPDOC
        $this->configureTransport($transport, $configManager->getLocal("appsettings","smtp"));
        $this->swiftMailer = \Swift_Mailer::newInstance($transport);
    }


    /**
     * @param \Swift_SmtpTransport $transport
     * @param IConfiguration $config
     *
     * @see http://swiftmailer.org/docs/sending.html  SwiftMailer: Sending Messages
     */
    private function configureTransport(\Swift_SmtpTransport $transport, IConfiguration $config) {
        $host = $config->Value("server",'localhost');
        $port = $config->Value('port',25);
        $username = $config->Value('username',false);
        $password = $config->Value('password',false);

        $transport->setHost($host);
        $transport->setPort($port);

        // For some reason the Swift_SmtpTransport methods SetUserName and SetPassword are exposed at runtime
        // but are not visible to the IDE in PhpStorm
        if ($username) {
            /** @noinspection PhpUndefinedMethodInspection */
            $transport->setUsername($username);
        };

        if ($password) {
            /** @noinspection PhpUndefinedMethodInspection */
            $transport->setPassword($password);
        }

    }





    /**
     * @param TEMailMessage $message
     * @return int
     * @see http://swiftmailer.org/docs/messages.html SwiftMailer: Creating Messages
     */
    public function send(TEMailMessage $message)
    {
        $contentType = $message->getContentType();
        $from = $message->getFromAddress()->toArray();
        $to = $message->getRecipientsAsArray();
        $subject = $message->getSubject();
        $textPart = $message->getTextPart();
        $body = $message->getMessageBody();
        $cc = $message->getCCsAsArray();
        $bcc = $message->getBCCsAsArray();
        $returnPath = $message->getReturnAddress();

        $swiftMessage = new \Swift_Message();
            // Give the message a subject
        $swiftMessage->setSubject($subject)
            // Set the From address with an associative array
            ->setFrom($from)
            // Set the To addresses with an associative array
            ->setTo($to);

        switch ($contentType) {
            case TContentType::$MultiPart:
                $swiftMessage->setBody($body,'text/html');
                $swiftMessage->addPart($textPart,'text/plain');
                break;
            case TContentType::$Html;
                $swiftMessage->setBody($body,'text/html');
                break;
            case TContentType::$Text:
                $swiftMessage->setBody($body,'text/plain');
                break;
        }

        if (!empty($cc)) {
            $swiftMessage->setCc($cc);
        }
        if (!empty($bcc)) {
            $swiftMessage->setBcc($cc);
        }

        if (!empty($returnPath)) {
            $swiftMessage->setReturnPath($returnPath->getAddress());
        }

        return $this->swiftMailer->send($swiftMessage);
    }
}