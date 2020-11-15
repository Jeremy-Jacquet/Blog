<?php

namespace App\src\blogFram;

use App\src\blogFram\Security;
use App\src\blogFram\Session;

class Request
{
    private $security;
    private $get;
    private $post;
    private $session;

    public function __construct()
    {
        $this->security = new Security();
        $this->session = new Session($_SESSION);
        $this->setGet();
        $this->setPost();
    }

    /**
     * @return Parameter
     */
    public function getGet()
    {
        return $this->get;
    }

    /**
     * @return Parameter
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @return Session
     */
    public function getSession()
    {
        return $this->session;
    }

    private function setGet()
    {
        if(isset($_GET)){
            $this->get = new Parameter($this->security->secureArray($_GET));
        }
    }

    private function setPost()
    {
        if(isset($_POST)){
            $this->post = new Parameter($this->security->secureArray($_POST));
        }
        
    }
}