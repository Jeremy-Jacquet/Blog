<?php

namespace App\src\blogFram;

use App\src\blogFram\Security;
use App\src\blogFram\Session;

/**
 * Request
 */
class Request
{    
    /**
     * @var Security
     */
    private $security;

    /**
     * @var Parameter
     */
    private $get;

    /**
     * @var Parameter
     */
    private $post;

    /**
     * @var Session
     */
    private $session;
    
    /**
     * Construct Request
     *
     * @return void
     */
    public function __construct()
    {
        $this->security = new Security();
        $this->session = new Session($_SESSION);
        $this->setGet();
        $this->setPost();
    }

    /**
     * Get $_GET parameters
     *
     * @return Parameter private $get
     */
    public function getGet()
    {
        return $this->get;
    }

    
    /**
     * Get $_POST parameters
     *
     * @return Parameter private $post
     */
    public function getPost()
    {
        return $this->post;
    }

    
    /**
     * Get session
     *
     * @return Session private $session
     */
    public function getSession()
    {
        return $this->session;
    }
    
    /**
     * Set $_GET parameters (security->secureArray($_GET)
     *
     * @return void
     */
    private function setGet()
    {
        if(isset($_GET)){
            $this->get = new Parameter($this->security->secureArray($_GET));
        }
    }
    
    /**
     * Set $_POST parameters (security->secureArray($_POST))
     *
     * @return void
     */
    private function setPost()
    {
        if(isset($_POST)){
            $this->post = new Parameter($this->security->secureArray($_POST));
        }
        
    }
}