<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;

class CommentController extends Controller
{
    /**
     * Add comment by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function addComment(Parameter $post)
    {
        if($post->get('submit')) {
            if($this->validation->validateInput('comment', $post)) {
                if($this->commentDAO->addComment($post, $this->date)) {
                    $this->alert->addSuccess("Merci, votre commentaire est soumis à validation.");
                }
            }
        }
    }

}