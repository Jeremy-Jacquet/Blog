<?php

namespace App\src\blogFram;

use App\src\blogFram\View;

class Message
{
    private $view;
    private $subject;
    private $body;

    public function __construct($category)
    {
        $this->view = new View;
        $this->category = $category;
        $this->setSubject();
    }

    public function setSubject()
    {
        if($this->category === 'register') {
            $this->subject = "E-mail de confirmation d'inscription";
        }
    }

    public function setPageSetting(Parameter $post, $token = null)
    {
        if($this->category === 'register' AND $token) {
            $this->body = $this->view->renderFile('../App/template/mail/mail_register.php', [
                'pseudo' => $post->get('pseudo'),
                'email' => $post->get('email'),
                'token' => $token
                ]);
        }
    }

    public function getSubject()
    {
        return $this->subject;
    }

    public function getBody()
    {
        return $this->body;
    }

}
