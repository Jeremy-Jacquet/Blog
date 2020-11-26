<?php

namespace App\src\blogFram;

use App\src\blogFram\View;

/**
 * Message
 */
class Message
{    
    /**
     * @var View
     */
    private $view;

    /**
     * @var string
     */
    private $subject;

    /**
     * @var mixed
     */
    private $body;
    
    /**
     * Construct Message
     *
     * @param  string $category
     * @return void
     */
    public function __construct($category)
    {
        $this->view = new View;
        $this->category = $category;
        $this->setSubject();
    }
    
    /**
     * Set message subject
     *
     * @return void
     */
    public function setSubject()
    {
        if($this->category === 'register') {
            $this->subject = "E-mail de confirmation d'inscription";
        }
    }
    
    /**
     * Set message page setting using view->renderFile()
     *
     * @param  Parameter $post
     * @param  string $token
     * @return void|mixed $view
     */
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
    
    /**
     * Get message subject
     *
     * @return string private $subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * Get message body
     *
     * @return mixed private $body
     */
    public function getBody()
    {
        return $this->body;
    }

}
