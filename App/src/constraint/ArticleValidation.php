<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;

/**
 * Article validation
 */
class ArticleValidation
{
    const TITLE_MIN = 2;
    const TITLE_MAX = 50;
    const SENTENCE_MIN = 100;
    const SENTENCE_MAX = 500;
    const CONTENT_MIN = 1000;
    const CONTENT_MAX = 50000;

    /**
     *
     * @var Alert
     */
    private $alert;

    /**
     * @var inputConstraint
     */
    private $inputConstraint;
    
    /**
     * construct ArticleValidation
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
     * check article constraints
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
            } elseif ($inputName === 'content') {
                $error = (!$this->checkContent($inputName, $value))? $error +1 : $error;
            } else {
                return false;
            }
        }
        return ($error > 0)? false : true;
    }
    
    /**
     * check article's title
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
     * check article's sentence
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

    /**
     * check article's content
     *
     * @param  string $inputName
     * @param  string $value
     * @return bool
     */
    private function checkContent($inputName, $value)
    {
        $error = 0;
        $error = (!$this->inputConstraint->notBlank($inputName, $value))? $error +1 : $error;
        $error = (!$this->inputConstraint->minLength($inputName, $value, self::CONTENT_MIN))? $error +1 : $error;
        $error = (!$this->inputConstraint->maxLength($inputName, $value, self::CONTENT_MAX))? $error +1 : $error;
        return ($error > 0)? false : true;
    }

}