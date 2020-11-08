<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;

class UserValidation extends Validation
{
    private $errors = [];
    private $constraint;

    public function __construct()
    {
        $this->constraint = new Constraint();
    }

    public function checkField(Parameter $post)
    {
        foreach ($post->all() as $key => $value) {
            if($key === 'pseudo') {
                $error = $this->checkPseudo($key, $value);
                $this->addError($key, $error);
            } elseif ($key === 'password') {
                $error = $this->checkPassword($key, $value);
                $this->addError($key, $error);
            } elseif($key === 'password2'){
                $error = $this->checkPassword2($post->get('password'), $post->get('password2'));
                $this->addError($key, $error);
            } elseif ($key === 'email') {
                $error = $this->checkEmail($key, $value);
                $this->addError($key, $error);
            }
        }
        return $this->errors;
    }

    private function addError($name, $error) {
        if($error) {
            $this->errors += [
                $name => $error
            ];
        }
    }

    private function checkPseudo($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('pseudo', $value);
        }
        if($this->constraint->minLength($name, $value, 2)) {
            return $this->constraint->minLength('pseudo', $value, 2);
        }
        if($this->constraint->maxLength($name, $value, 50)) {
            return $this->constraint->maxLength('pseudo', $value, 50);
        }
        /*
        if($this->constraint->allowedCharacters($value)) {
            return $this->constraint->allowedCharacters($value);
        }
        */
    }

    private function checkPassword($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('password', $value);
        }
        if($this->constraint->minLength($name, $value, 6)) {
            return $this->constraint->minLength('password', $value, 6);
        }
        if($this->constraint->maxLength($name, $value, 50)) {
            return $this->constraint->maxLength('password', $value, 255);
        }
    }

    private function checkPassword2($password, $password2)
    {
        if($this->constraint->samePassword($password, $password2)) {
            return $this->constraint->samePassword($password, $password2);
        }
    }

    private function checkEmail($name, $value)
    {
        if($this->constraint->notBlank($name, $value)) {
            return $this->constraint->notBlank('email', $value);
        }
        if($this->constraint->minLength($name, $value, 6)) {
            return $this->constraint->minLength('email', $value, 6);
        }
        if($this->constraint->maxLength($name, $value, 78)) {
            return $this->constraint->maxLength('email', $value, 78);
        }
    }

    
}
