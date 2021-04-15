<?php

namespace App\src\blogFram;

/**
 * Message
 */
class Message
{    
    /**
     * @var string
     */
    private $subject;

    /**
     * @var mixed
     */
    private $body;
    
    /**
     * messageOf    ex: register
     *
     * @var string
     */
    private $messageOf;
    
    /**
     * construct Message
     *
     * @param  string $messageOf
     * @return void
     */
    public function __construct($messageOf)
    {
        $this->category = $messageOf;
        $this->setSubject();
        return $this;
    }
    
    /**
     * set message subject
     *
     * @return void
     */
    private function setSubject()
    {
        if($this->messageOf === 'register') {
            $this->subject = "E-mail de confirmation d'inscription";
        }
    }

    /**
     * get message subject
     *
     * @return string $subject
     */
    public function getSubject()
    {
        return $this->subject;
    }
    
    /**
     * get message body
     *
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }
    
    /**
     * set page setting
     *
     * @param  Parameter $post
     * @return void
     */
    public function setPageSetting($post)
    {
        if($this->messageOf === 'register') {
            $this->setPageSettingForRegister($post);
        } elseif ($this->messageOf === 'contactUser') {
            $this->setPageSettingForContactToUser($post);
        } elseif ($this->messageOf === 'contactAdmin') {
            $this->setPageSettingForContactToAdmin($post);
        }
    }
    
    /**
     * set page setting for register
     *
     * @param  Parameter $post
     * @return void
     */
    private function setPageSettingForRegister($post) 
    {
        $this->body = $this->renderFile('../App/template/mail/mail_register.php', [
        'pseudo' => $post->get('pseudo'),
        'email' => $post->get('email'),
        'token' => $post->get('token')
        ]);
    }

    /**
     * set page setting for contact to user
     *
     * @param  Parameter $post
     * @return void
     */
    private function setPageSettingForContactToUser($post) 
    {
        $this->body = $this->renderFile('../App/template/mail/contact_user.php', [
        'name' => $post->get('name'),
        'email' => $post->get('email'),
        'content' => $post->get('content')
        ]);
    }

    /**
     * set page setting for contact to admin
     *
     * @param  Parameter $post
     * @return void
     */
    private function setPageSettingForContactToAdmin($post) 
    {
        $this->body = $this->renderFile('../App/template/mail/contact_admin.php', [
        'name' => $post->get('name'),
        'email' => $post->get('email'),
        'content' => $post->get('content')
        ]);
    }

    /**
     * render file for view
     *
     * @param  string $file 
     * @param  array $data      variables to extract
     * @return mixed|void
     */
    private function renderFile($file, $data)
    {
        if(file_exists($file)){
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        header('Location: index.php?route=notFound');
        exit;
    }

}
