<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;

class CommentController extends Controller
{
    /**
     * Add comment by user
     *
     * @param  Parameter $post
     * @return bool
     */
    public function addComment(Parameter $post)
    {
        if($post->get('submit')) {
            if(!$this->validation->validateInput('comment', $post)) {
                return false;
            }
            $this->commentDAO->addComment($post, $this->date);
            $this->alert->addSuccess("Merci, votre commentaire est soumis à validation.");
            return true;
        }
    }
    
    /**
     * Moderate comment
     *
     * @param  Parameter $post
     * @return bool
     */
    public function moderateComment(Parameter $post)
    {
        $result = true;
        if($post->get('action') === 'validate') {
            $this->commentDAO->updateComment($post, parent::ACTIVE_COMMENT);
        } elseif($post->get('action') === 'refuse') {
            $this->commentDAO->updateComment($post, parent::INACTIVE_COMMENT);
        } elseif($post->get('action') === 'pending') {
            $this->commentDAO->updateComment($post, parent::PENDING_COMMENT);
        } elseif($post->get('action') === 'add') {
            $result = $this->addComment($post);
        } elseif($post->get('action') === 'delete') {
            $this->commentDAO->deleteComment($post);
        } else {
            $this->alert->addError("L'action ".$post->get('action')." n'est pas prévue.");
        }
        return $result;
    }

}