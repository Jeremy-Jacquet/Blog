<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;
use App\src\blogFram\Alert;

class UserValidation
{
    private $inputConstraint;
    private $alert;

    const PSEUDO_MIN = 2;
    const PSEUDO_MAX = 50;
    const PASSWORD_MIN = 6;
    const PASSWORD_MAX = 72;
    const EMAIL_MIN = 6;
    const EMAIL_MAX = 78;

    public function __construct()
    {
        $this->inputConstraint = new InputConstraint();
        $this->alert = new Alert();
    }

    public function checkField(Parameter $post)
    {
        $error = 0;
        foreach($post->all() as $key => $value) {
            if($key === 'pseudo') {
                if($this->checkPseudo($key, $value)) {
                    $this->alert->addError($this->checkPseudo($key, $value));
                    $error++;
                }
            } elseif ($key === 'password') {
                if($this->checkPassword($key, $value)) {
                    $this->alert->addError($this->checkPassword($key, $value));
                    $error++;
                }
            } elseif($key === 'passwordConfirm'){
                if($this->checkIsSame($value, $post->get('password'))) {
                    $this->alert->addError($this->checkIsSame($value, $post->get('password')));
                    $error++;
                } 
            } elseif ($key === 'email') {
                if($this->checkEmail($key, $value)) {
                    $this->alert->addError($this->checkEmail($key, $value));
                    $error++;
                }
            }
            elseif($key === 'emailConfirm'){
                if($this->checkIsSame($value, $post->get('email'))) {
                    var_dump($this->checkIsSame($value, $post->get('email')));
                    $this->alert->addError($this->checkIsSame($value, $post->get('email')));
                    $error++;
                } 
            }
        }
        return ($error)? false : true;
    }

    private function checkPseudo($name, $value)
    {
        if($this->inputConstraint->notBlank($name, $value)) {
            return $this->inputConstraint->notBlank('pseudo', $value);
        }
        if($this->inputConstraint->minLength($name, $value, self::PSEUDO_MIN)) {
            return $this->inputConstraint->minLength('pseudo', $value, self::PSEUDO_MIN);
        }
        if($this->inputConstraint->maxLength($name, $value, self::PSEUDO_MAX)) {
            return $this->inputConstraint->maxLength('pseudo', $value, self::PSEUDO_MAX);
        }
        if($this->inputConstraint->allowCharacter($value)) {
            return $this->inputConstraint->allowCharacter($value);
        }
    }

    private function checkPassword($name, $value)
    {
        if($this->inputConstraint->notBlank($name, $value)) {
            return $this->inputConstraint->notBlank('password', $value);
        }
        if($this->inputConstraint->minLength($name, $value, self::PASSWORD_MIN)) {
            return $this->inputConstraint->minLength('password', $value, self::PASSWORD_MIN);
        }
        if($this->inputConstraint->maxLength($name, $value, self::PASSWORD_MAX)) {
            return $this->inputConstraint->maxLength('password', $value, self::PASSWORD_MAX);
        }
    }

    private function checkIsSame($data, $dataConfirm)
    {
        if($this->inputConstraint->isSame($data, $dataConfirm)) {
            return $this->inputConstraint->isSame($data, $dataConfirm);
        }
    }

    private function checkEmail($name, $value)
    {
        if($this->inputConstraint->notBlank($name, $value)) {
            return $this->inputConstraint->notBlank('email', $value);
        }
        if($this->inputConstraint->minLength($name, $value, self::EMAIL_MIN)) {
            return $this->inputConstraint->minLength('email', $value, self::EMAIL_MIN);
        }
        if($this->inputConstraint->maxLength($name, $value, self::EMAIL_MAX)) {
            return $this->inputConstraint->maxLength('email', $value, self::EMAIL_MAX);
        }
        if($this->inputConstraint->validEmail($value)) {
            return $this->inputConstraint->validEmail($value);
        }
    }
    
}