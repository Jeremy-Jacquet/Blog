<?php

namespace App\src\blogFram;

class Mailer
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $transport;
    private $mailer;
    private $message;

    public function __construct($host = MAILER_HOST, $port = MAILER_PORT, $username = MAILER_USERNAME, $password = MAILER_PASSWORD)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->setTransport();
        $this->mailer = new \Swift_Mailer($this->transport);
    }

    public function sendMail($category, Parameter $post, $token = null)
    {
        $this->setMessage($category, $post, $token);
        $this->setMail($post->get('email'));
        $this->mailer->send($this->mail);
    }

    public function setMessage($category, Parameter $post, $token = null)
    {
        $this->message = new Message($category);
        $this->message->setPageSetting($post, $token);
    }

    public function setMail($toEmail)
    {
        $this->mail = (new \Swift_Message($this->message->getSubject()))
        ->setFrom([FROM_EMAIL => FROM_USERNAME])
        ->setTo([$toEmail])
        ->setBody($this->message->getBody(), 'text/html');
    }

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
