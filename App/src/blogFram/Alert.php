<?php

namespace App\src\blogFram;

/**
 * Alert
 */
class Alert
{    
    /**
     * @var Session
     */
    private $session;    

    /**
     * @var array [string]
     */
    private $error;    
    
    /**
     * @var array [string]
     */
    private $success;
    
    /**
     * Construct Alert
     *
     * @return void
     */
    public function __construct()
    {
        $this->session = new Session($_SESSION);
    }
    
    /**
     * Add error on $_SESSION['error']
     *
     * @param  string $message
     * @return void
     */
    public function addError($message)
    {
        if($message) {
            $this->error[] = $message;
            $this->session->set('error', $this->error);
        }
    }

    /**
     * Add error on $_SESSION['success']
     *
     * @param  string $message
     * @return void
     */
    public function addSuccess($message)
    {
        if($message) {
            $this->success[] = $message;
            $this->session->set('success', $this->success);
        }
    }
    
    /**
     * Check if exist some alerts
     *
     * @return void|true (true if some alerts exist)
     */
    public function checkAlert()
    {
        if($this->getSuccess() OR $this->getError()) {
            return true;
        }
    }

    /**
     * Check if exist some errors
     *
     * @return void|true (true if some errors exist)
     */
    public function checkError()
    {
        if($this->getError()) {
            return true;
        }
    }

    /**
     * Check if exist some successes
     *
     * @return void|true (true if some successes exist)
     */
    public function checkSuccess()
    {
        if($this->getSuccess()) {
            return true;
        }
    }
    
    /**
     * Get errors
     *
     * @return array [string]
     */
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

    /**
     * Get successes
     *
     * @return array [string]
     */
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
    
    /**
     * Show errors (foreach)
     *
     * @return void|string (string = error)
     */
    public function showError()
    {
        $errors = $this->getError();
        if($errors) {
            $this->session->remove('error');
            foreach($errors as $key => $message){
                echo "<p class=\"text-center  m-auto\">$message</p>";
            }
        }
    }

    /**
     * Show successes (foreach)
     *
     * @return void|string (string = success)
     */
    public function showSuccess()
    {
        $successes = $this->getSuccess();
        if($successes) {
            $this->session->remove('success');
            foreach($successes as $key => $message){
                echo "<p class=\"text-center  m-auto\">$message</p>";
            }
        }
    }

}