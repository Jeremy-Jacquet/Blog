<?php

namespace App\src\blogFram;

class Mail
{
    private $subject;       //ex: 'Mon premier mail avec swift mailer'
    private $fromEmail;     //ex: 'toto@toto.com'
    private $fromUser;      //ex: 'Toto'
    private $toEmail;       //ex: 'receiver@domain.org'
    private $body;          //ex: '<!DOCTYPE html>...
    private $message;

    public function __construct($subject, $fromEmail, $fromUser, $toEmail, $body)
    {
        $this->setSubject($subject);
        $this->setFromEmail($fromEmail);
        $this->setFromUser($fromUser);
        $this->setToEmail($toEmail);
        $this->setBody($body);
        $this->setMessage();
    }

    /* SETTERS */

    public function setMessage()
    {
        $this->message = (new \Swift_Message($this->subject))
        ->setFrom([$this->fromEmail => $this->fromUser])
        ->setTo([$this->toEmail])
        ->setBody($this->body, 'text/html');
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;
    }

    public function setFromUser($fromUser)
    {
        $this->fromUser = $fromUser;
    }

    public function setToEmail($toEmail)
    {
        $this->toEmail = $toEmail;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    /* GETTERS */

    public function getSubject()
    {
        return $this->subject;
    }

    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    public function getFromUser()
    {
        return $this->fromUser;
    }

    public function getToEmail()
    {
        return $this->toEmail;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getMessage()
    {
        return $this->message;
    }

}
