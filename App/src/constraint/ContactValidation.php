<?php

namespace App\src\constraint;

use App\src\blogFram\Alert;

/**
 * ContactValidation
 */
class ContactValidation
{
    const MESSAGE_MIN = 6;
    const MESSAGE_MAX = 2000;

    /**
     * @var ContactConstraint
     */
    private $contactConstraint;

    /**
     * @var Alert
     */
    private $alert;
    
    /**
     * Construct ContactValidation
     *
     * @return void
     */
    public function __construct()
    {
        $this->inputConstraint = new InputConstraint();
        $this->alert = new Alert();
    }
    
    /**
     * Check input constraint
     *
     * @param  mixed $message
     * @return bool (true if all good)
     */
    public function checkMessage($message)
    {   
        $error = 0;
        if($this->inputConstraint->notBlank($message)) {
            $this->alert->addErrorComment($this->inputConstraint->notBlank($message));
            $error++;
        }
        if($this->inputConstraint->minLength($message, self::MESSAGE_MIN)) {
            $this->alert->addErrorComment($this->inputConstraint->minLength($message, self::MESSAGE_MIN));
            $error++;
        }
        if($this->inputConstraint->maxLength($message, self::MESSAGE_MAX)) {
            $this->alert->addErrorComment($this->inputConstraint->maxLength($message, self::MESSAGE_MAX));
            $error++;
        }
        /*
        if($this->inputConstraint->allowWord($content)) {
            return $this->inputConstraint->allowWord($content);
        }
        */
        return ($error === 0)? true : false;
    }
}