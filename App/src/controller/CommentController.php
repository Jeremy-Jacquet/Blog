<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Alert;
use App\src\constraint\Validation;
use App\src\DAO\CommentDAO;

class CommentController
{
    private $alert;
    private $validation;
    private $commentDAO;

    public function __construct($alert, $validation)
    {
        $this->alert = $alert;
        $this->validation = $validation;
        $this->commentDAO = new CommentDAO;
    }

    public function addComment($post)
    {
        $newCommentId = $this->commentDAO->addComment($post);
        return $newCommentId;
    }

    public function updateComment($post)
    {
        $isSuccess = $this->commentDAO->updateComment($post);
        return $isSuccess;
    }

    public function deleteComment($post)
    {
        $isSuccess = $this->commentDAO->deleteComment($post);
        return $isSuccess;
    }
    
    /**
     * getComments
     *
     * @param  array|string $attributes (ex: 'all' or [['name' => status, 'value' => 1, 'parameter' => 'integer']])
     * @param  mixed $limit
     * @param  mixed $start
     * @return void
     */
    public function getComments($attriutes, $limit = null, $start = null)
    {
        $comments = $this->commentDAO->getComments($attriutes, $limit, $start);
        return $comments;
    }

    public function countComments($attributes)
    {
        return $this->commentDAO->countComments($attributes);
    }

}