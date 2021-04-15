<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;

/**
 * UserValidation
 */
class UserValidation
{
    const PSEUDO_MIN = 2;
    const PSEUDO_MAX = 50;
    const PASSWORD_MIN = 6;
    const PASSWORD_MAX = 72;
    const EMAIL_MIN = 6;
    const EMAIL_MAX = 78;
    
    /**
     * @var Alert
     */
    private $alert;
    
    /**
     * @var InputConstraint
     */
    private $inputConstraint;
    
    /**
     * construct UserValidation
     *
     * @param  Alert $alert
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
        $this->inputConstraint = new InputConstraint($this->alert);
    }
    
    /**
     * check input field about user
     *
     * @param  Parameter $post
     * @return bool
     */
    public function checkField($post)
    {
        $error = 0;
        $post->delete(['submit']);
        foreach($post->all() as $inputName => $value) {
            if($inputName === 'pseudo') {
                $error = (!$this->checkPseudo($inputName, $value))? $error +1 : $error;
            } elseif ($inputName === 'password') {
                $error = (!$this->checkPassword($inputName, $value))? $error +1 : $error;
            } elseif($inputName === 'passwordConfirm'){
                $error = (!$this->checkIsSame($value, $post->get('password')))? $error +1 : $error;
            } elseif ($inputName === 'email') {
                $error = (!$this->checkEmail($inputName, $value))? $error +1 : $error;
            } elseif($inputName === 'emailConfirm'){
                $error = (!$this->checkIsSame($value, $post->get('email')))? $error +1 : $error;
            } else {
                return false;
            }
        }
        return ($error > 0)? false : true;
    }
    
    /**
     * check pseudo constraints
     *
     * @param  string $inputName
     * @param  string $value
     * @return bool
     */
    private function checkPseudo($inputName, $value)
    {
        $error = 0;
        $error = (!$this->inputConstraint->notBlank($inputName, $value))? $error +1 : $error;
        $error = (!$this->inputConstraint->minLength($inputName, $value, self::PSEUDO_MIN))? $error +1 : $error;
        $error = (!$this->inputConstraint->maxLength($inputName, $value, self::PSEUDO_MAX))? $error +1 : $error;
        $error = (!$this->inputConstraint->allowCharacter($value))? $error +1 : $error;
        return ($error > 0)? false : true;
    }

    /**
     * check password constraints
     *
     * @param  string $inputName
     * @param  string $value
     * @return bool
     */
    private function checkPassword($inputName, $value)
    {
        $error = 0;
        $error = (!$this->inputConstraint->notBlank($inputName, $value))? $error +1 : $error;
        $error = (!$this->inputConstraint->minLength($inputName, $value, self::PASSWORD_MIN))? $error +1 : $error;
        $error = (!$this->inputConstraint->maxLength($inputName, $value, self::PASSWORD_MAX))? $error +1 : $error;
        return ($error > 0)? false : true;
    }
    
    /**
     * check if is same
     *
     * @param  string $data
     * @param  string $dataToConfirm
     * @return bool
     */
    private function checkIsSame($data, $dataToConfirm)
    {
        return (!$this->inputConstraint->checkIsSame($data, $dataToConfirm))? false : true;
    }
     
    /**
     * check email constraints
     *
     * @param  string $inputName
     * @param  string $value
     * @return bool
     */
    private function checkEmail($inputName, $value)
    {
        $error = 0;
        $error = (!$this->inputConstraint->notBlank($inputName, $value))? $error +1 : $error;
        $error = (!$this->inputConstraint->minLength($inputName, $value, self::EMAIL_MIN))? $error +1 : $error;
        $error = (!$this->inputConstraint->maxLength($inputName, $value, self::EMAIL_MAX))? $error +1 : $error;
        $error = (!$this->inputConstraint->validEmail($value))? $error +1 : $error;
        return ($error)? false : true;
    }
    
}