<?php

namespace App\src\router;

use App\src\blogFram\Parameter;
use App\src\router\RequestSecurity;

/**
 * Request
 */
class HTTPRequest
{    
    private $get;
    private $post;
    private $file;
    
    public function __construct()
    {
        $this->setGet();
        $this->setPost();
        $this->setFile();
    }

    public function getGet()
    {
        return $this->get;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function getFile()
    {
        return $this->file;
    }
        
    private function setGet()
    {
        if(!empty($_GET)){
            $security = new RequestSecurity;
            if($security->checkIfAutorizeParameterGet() && $security->filterGet()) {
                $getArray = $security->filterGet();
                $this->get = new Parameter($getArray);
            } else {
                $this->get = 'notValid';
            }
        } else {
            $this->get = new Parameter($_GET);
        }
    }
    
    private function setPost()
    {
        if(!empty($_POST)){
            $security = new RequestSecurity;
            if($security->checkIfAutorizeParameterPost() && $security->filterPost()) {
                $postArray = $security->filterPost(); 
                $this->post = new Parameter($postArray);
            } else {
                $this->post = 'notValid';
            }
        } else {
            $this->post = new Parameter($_POST);
        }
    }

    private function setFile()
    {   
        $this->file = new Parameter($_FILES);
    }

}
