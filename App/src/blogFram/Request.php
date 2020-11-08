<?php

namespace App\src\blogFram;

class Request
{
    private $security;
    private $get;
    private $post;

    public function __construct()
    {
        $this->security = new Security();
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

    public function setGet()
    {
        if(isset($_GET)){
            $this->get = new Parameter($this->security->secureArray($_GET));
        }
    }

    public function setPost()
    {
        if(isset($_POST)){
            $this->post = new Parameter($this->security->secureArray($_POST));
        }
        
    }
}