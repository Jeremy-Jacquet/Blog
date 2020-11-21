<?php

namespace App\src\blogFram;

class Alert
{
    private $session;
    private $error;
    private $success;

    public function __construct()
    {
        $this->session = new Session($_SESSION);
    }

    public function addError($message)
    {
        if($message) {
            $this->error[] = $message;
            $this->session->set('error', $this->error);
        }
    }

    public function addSuccess($message)
    {
        if($message) {
            $this->success[] = $message;
            $this->session->set('success', $this->success);
        }
    }

    public function checkAlert()
    {
        if($this->getSuccess() OR $this->getError()) {
            return true;
        }
    }

    public function checkError()
    {
        if($this->getError()) {
            return true;
        }
    }

    public function checkSuccess()
    {
        if($this->getSuccess()) {
            return true;
        }
    }

    public function getError()
    {
        $errors = [];
        if($this->session->get('error')) {   
            foreach($this->session->get('error') as $key => $message){
                $errors[] = $message;
            }         
        }
        return $errors;
    }

    public function getSuccess()
    {
        $successes = [];
        if($this->session->get('success')) {
            foreach($this->session->get('success') as $key => $message){
                $successes[] = $message;
            }
        }
        return $successes;
    }

    public function showError()
    {
        $errors = $this->getError();
        if($errors) {
            $this->session->remove('error');
            foreach($errors as $key => $message){
                echo '<p class="text-center  m-auto">'.$message.'</p>';
            }
        }
    }

    public function showSuccess()
    {
        $successes = $this->getSuccess();
        if($successes) {
            $this->session->remove('success');
            foreach($successes as $key => $message){
                echo '<p class="text-center  m-auto">'.$message.'</p>';
            }
        }
    }

}