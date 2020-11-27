<?php

namespace App\src\constraint;

use App\src\blogFram\Alert;

/**
 * CommentValidation
 */
class CommentValidation
{
    const COMMENT_MIN = 6;
    const COMMENT_MAX = 2000;

    /**
     * @var CommentConstraint
     */
    private $commentConstraint;

    /**
     * @var Alert
     */
    private $alert;
    
    /**
     * Construct CommentValidation
     *
     * @return void
     */
    public function __construct()
    {
        $this->commentConstraint = new CommentConstraint();
        $this->alert = new Alert();
    }
    
    /**
     * Check comment constraint
     *
     * @param  mixed $content
     * @return bool (true if all good)
     */
    public function checkComment($content)
    {   
        $error = 0;
        if($this->commentConstraint->notBlank($content)) {
            $this->alert->addErrorComment($this->commentConstraint->notBlank($content));
            $error++;
        }
        if($this->commentConstraint->minLength($content, self::COMMENT_MIN)) {
            $this->alert->addErrorComment($this->commentConstraint->minLength($content, self::COMMENT_MIN));
            $error++;
        }
        if($this->commentConstraint->maxLength($content, self::COMMENT_MAX)) {
            $this->alert->addErrorComment($this->commentConstraint->maxLength($content, self::COMMENT_MAX));
            $error++;
        }
        /*
        if($this->commentConstraint->allowWord($content)) {
            return $this->commentConstraint->allowWord($content);
        }
        */
        return ($error === 0)? true : false;
    }
}