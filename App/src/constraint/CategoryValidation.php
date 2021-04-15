<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;

/**
 * Category validation
 */
class CategoryValidation
{
    const TITLE_MIN = 2;
    const TITLE_MAX = 50;
    const SENTENCE_MIN = 100;
    const SENTENCE_MAX = 500;
        
    /**
     * @var Alert
     */
    private $alert;

    /**
     * @var InputConstraint
     */
    private $inputConstraint;
    
    /**
     * construct CategoryValidation
     *
     * @param  Alert $alert
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
        $this->inputConstraint = new InputConstraint($alert);
    }
    
    /**
     * check category constraints
     *
     * @param  Parameter $post
     * @return bool
     */
    public function checkField($post)
    {
        $error = 0;
        $post->delete(['submit']);
        foreach($post->all() as $inputName => $value) {
            if($inputName === 'title') {
                $error = (!$this->checkTitle($inputName, $value))? $error +1 : $error;
            } elseif ($inputName === 'sentence') {
                $error = (!$this->checkSentence($inputName, $value))? $error +1 : $error;
            } else {
                return false;
            }
        }
        return ($error > 0)? false : true;
    }
    
    /**
     * check category's title
     *
     * @param  string $inputName
     * @param  string $value
     * @return bool
     */
    private function checkTitle($inputName, $value)
    {
        $error = 0;
        $error = (!$this->inputConstraint->notBlank($inputName, $value))? $error +1 : $error;
        $error = (!$this->inputConstraint->minLength($inputName, $value, self::TITLE_MIN))? $error +1 : $error;
        $error = (!$this->inputConstraint->maxLength($inputName, $value, self::TITLE_MAX))? $error +1 : $error;
        return ($error > 0)? false : true;
    }

    /**
     * check category's sentence
     *
     * @param  string $inputName
     * @param  string $value
     * @return bool
     */
    private function checkSentence($inputName, $value)
    {
        $error = 0;
        $error = (!$this->inputConstraint->notBlank($inputName, $value))? $error +1 : $error;
        $error = (!$this->inputConstraint->minLength($inputName, $value, self::SENTENCE_MIN))? $error +1 : $error;
        $error = (!$this->inputConstraint->maxLength($inputName, $value, self::SENTENCE_MAX))? $error +1 : $error;
        return ($error > 0)? false : true;
    }

}