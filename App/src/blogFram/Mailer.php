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
    private $transport;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Message
     */
    private $message;
    
    /**
     * Construct Mailer
     *
     * @param  string $host
     * @param  int $port
     * @param  string $username
     * @param  string $password
     * @return void
     */
    public function __construct($host = MAILER_HOST, $port = MAILER_PORT, $username = MAILER_USERNAME, $password = MAILER_PASSWORD)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->setTransport();
        $this->mailer = new \Swift_Mailer($this->transport);
    }
    
    /**
     * Send mail
     *
     * @param  string $category (ex: register)
     * @param  object $post
     * @param  string $token
     * @return void
     */
    public function sendMail($category, Parameter $post, $token = null)
    {
        $this->setMessage($category, $post, $token);
        $this->setMail($post->get('email'));
        $this->mailer->send($this->mail);
    }
    
    /**
     * Set mail message
     *
     * @param  string $category (ex: register)
     * @param  array $post[]
     * @param  string $token
     * @return void
     */
    public function setMessage($category, Parameter $post, $token = null)
    {
        $this->message = new Message($category);
        $this->message->setPageSetting($post, $token);
    }
    
    /**
     * Set mail
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
     * Set transport
     *
     * @return void
     */
    public function setTransport()
    {
        $https['ssl']['verify_peer'] = FALSE;
        $https['ssl']['verify_peer_name'] = FALSE;
        $this->transport = (new \Swift_SmtpTransport($this->host, $this->port))
        ->setUsername($this->username)
        ->setPassword($this->password);
        //->setEncryption(EMAIL_ENCRYPTION); //For Gmail
    }

}
