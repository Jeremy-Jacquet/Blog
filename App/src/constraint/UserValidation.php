<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;
use App\src\blogFram\Alert;

class UserValidation
{
    private $constraint;
    private $alert;

    const PSEUDO_MIN = 2;
    const PSEUDO_MAX = 50;
    const PASSWORD_MIN = 6;
    const PASSWORD_MAX = 72;
    const EMAIL_MIN = 6;
    const EMAIL_MAX = 78;

    public function __construct()
    {
        $this->constraint = new Constraint();
        $this->alert = new Alert();
    }

    public function checkField(Parameter $post)
    {
        $error = 0;
        foreach($post->all() as $key => $value) {
            if($key === 'pseudo') {
                if($this->checkPseudo($key, $value)) {
                    $this->alert->addError($this->checkPseudo($key, $value));
                    $error = +1;
                }
            } elseif ($key === 'password') {
                if($this->checkPassword($key, $value)) {
                    $this->alert->addError($this->checkPassword($key, $value));
                    $error = +1;
                }
            } elseif($key === 'passwordConfirm'){
                if($this->checkIsSame($value, $post->get('password'))) {
                    $this->alert->addError($this->checkIsSame($value, $post->get('password')));
                    $error = +1;
                } 
            } elseif ($key === 'email') {
                if($this->checkEmail($key, $value)) {
                    $this->alert->addError($this->checkEmail($key, $value));
                    $error = +1;
                }
            }
            elseif($key === 'emailConfirm'){
                if($this->checkIsSame($value, $post->get('email'))) {
                    var_dump($this->checkIsSame($value, $post->get('email')));
                    $this->alert->addError($this->checkIsSame($value, $post->get('email')));
                    $error = +1;
                } 
            }
        }
        return ($error)? false : true;
    }

    private function checkPseudo($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('pseudo', $value);
        }
        if($this->constraint->minLength($name, $value, self::PSEUDO_MIN)) {
            return $this->constraint->minLength('pseudo', $value, self::PSEUDO_MIN);
        }
        if($this->constraint->maxLength($name, $value, self::PSEUDO_MAX)) {
            return $this->constraint->maxLength('pseudo', $value, self::PSEUDO_MAX);
        }
        if($this->constraint->allowCharacter($value)) {
            return $this->constraint->allowCharacter($value);
        }
    }

    private function checkPassword($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('password', $value);
        }
        if($this->constraint->minLength($name, $value, self::PASSWORD_MIN)) {
            return $this->constraint->minLength('password', $value, self::PASSWORD_MIN);
        }
        if($this->constraint->maxLength($name, $value, self::PASSWORD_MAX)) {
            return $this->constraint->maxLength('password', $value, self::PASSWORD_MAX);
        }
    }

    private function checkIsSame($data, $dataConfirm)
    {
        if($this->constraint->isSame($data, $dataConfirm)) {
            return $this->constraint->isSame($data, $dataConfirm);
        }
    }

    private function checkEmail($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('email', $value);
        }
        if($this->constraint->minLength($name, $value, self::EMAIL_MIN)) {
            return $this->constraint->minLength('email', $value, self::EMAIL_MIN);
        }
        if($this->constraint->maxLength($name, $value, self::EMAIL_MAX)) {
            return $this->constraint->maxLength('email', $value, self::EMAIL_MAX);
        }
        if($this->constraint->validEmail($value)) {
            return $this->constraint->validEmail($value);
        }
    }
    
}