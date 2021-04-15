<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;
use App\src\constraint\InputConstraint;

/**
 * CommentValidation
 */
class CommentValidation
{
    const COMMENT_MIN = 6;
    const COMMENT_MAX = 2000;

    /**
     * @var Alert
     */
    private $alert;

    /**
     * @var InputConstraint
     */
    private $inputConstraint;
    
    /**
     * construct CommentValidation
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
     * check input field about user
     *
     * @param  Parameter $post
     * @return bool
     */
    public function checkField(Parameter $post)
    {
        $post->delete(['submit', 'action', 'articleId', 'userId']);
        if(!$post->get('content')) { 
            return false;
        }
        return $this->checkComment('contenu', $post->get('content'));
    }
    
    /**
     * check comment constraint
     *
     * @param  string $content
     * @return bool
     */
    public function checkComment($content)
    {   
        $error = 0;
        $error = (!$this->inputConstraint->notBlank($content))? $error +1 : $error;
        $error = (!$this->inputConstraint->minLength($content, self::COMMENT_MIN))? $error +1 : $error;
        $error = (!$this->inputConstraint->maxLength($content, self::COMMENT_MAX))? $error +1 : $error;
        return ($error > 0)? false : true;
    }
}