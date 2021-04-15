<?php

namespace App\src\blogFram;

/**
 * Mailer
 */
class Mailer
{    
    /**
     * @var string
     */
    private $host;   

    /**
     * @var mixed
     */
    private $mail;
        
    /**
     * @var int
     */
    private $port;
        
    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \Swift_Transport
     */
    private $swiftTransport;

    /**
     * @var \Swift_Mailer
     */
    private $swiftMailer;

    /**
     * @var Message
     */
    private $message;
    
    /**
     * construct Mailer
     *
     * @param  string $host
     * @param  int $port
     * @param  string $username
     * @param  string $password
     * @return Mailer
     */
    public function __construct($host = MAILER_HOST, $port = MAILER_PORT, $username = MAILER_USERNAME, $password = MAILER_PASSWORD)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->setSwiftTransport();
        $this->swiftMailer = new \Swift_Mailer($this->swiftTransport);
        return $this;
    }
    
    /**
     * send mail
     *
     * @param  string $mailOf ex: register
     * @param  Parameter $post
     * @return void
     */
    public function sendMail($mailOf, $post)
    {
        if($mailOf === 'contact') { 
            $this->setMessage('contactAdmin', $post);
            $this->setMail(ADMIN_EMAIL);
            $this->swiftMailer->send($this->mail);
            $this->setMessage('contactUser', $post);
            $this->setMail($post->get('email'));
            $this->swiftMailer->send($this->mail);
            return true;
        }
        $this->setMessage($mailOf, $post);
        $this->setMail($post->get('email'));
        $this->swiftMailer->send($this->mail);
    }
    
    /**
     * set mail message
     *
     * @param  string $messageOf ex: register
     * @param  Parameter $post
     * @return void
     */
    public function setMessage($messageOf, $post)
    {
        $this->message = new Message($messageOf);
        $this->message->setPageSetting($post);
    }
    
    /**
     * set mail
     *
     * @param  string $toEmail
     * @return void
     */
    public function setMail($toEmail)
    {
        $this->mail = (new \Swift_Message($this->message->getSubject()))
        ->setFrom([FROM_EMAIL => FROM_USERNAME])
        ->setTo([$toEmail])
        ->setBody($this->message->getBody(), 'text/html');
    }
    
    /**
     * set transport
     *
     * @return void
     */
    public function setSwiftTransport()
    {
        $https['ssl']['verify_peer'] = FALSE;
        $https['ssl']['verify_peer_name'] = FALSE;
        $this->swiftTransport = (new \Swift_SmtpTransport($this->host, $this->port))
        ->setUsername($this->username)
        ->setPassword($this->password);
        //->setEncryption(EMAIL_ENCRYPTION); //For Gmail
    }

}
