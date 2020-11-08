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
    private $mail;
    private $result;

    public function __construct($host = MAILER_HOST, $port = MAILER_PORT, $username = MAILER_USERNAME, $password = MAILER_PASSWORD)
    {
        $this->setHost($host);
        $this->setPort($port);
        $this->setUsername($username);
        $this->setPassword($password);
        $this->setTransport();
        $this->setMailer();
    }

    public function setMail($subject, $fromEmail, $fromUser, $toEmail, $body)
    {
        $this->mail = new Mail($subject, $fromEmail, $fromUser, $toEmail, $body);
    }

    public function sendMail()
    {
        $this->result = $this->mailer->send($this->mail->getMessage());
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

    public function setMailer()
    {
        $this->mailer = new \Swift_Mailer($this->transport);
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    
    public function getMail()
    {
        return $this->mail;
    }

    public function getResult()
    {
        return $this->result;
    }
}
