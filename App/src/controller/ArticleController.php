<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Image;

class ArticleController extends Controller
{
/**
     * Add article
     *
     * @param  Parameter $post
     * @return false|int (int = articleId)
     */
    public function addArticle(Parameter $post)
    {
        if($this->validation->validateInput('article', $post)) {
            $id = $this->articleDAO->addArticle($post, $this->date);
            $post->set('id', $id);
            $image = new Image('article', $_FILES['picture'], $post->get('id'));
            if($image->checkImage('article', $_FILES['picture'])) {
                if($image->upload($_FILES['picture'])) {
                    $post->set('filename', $image->getFilename());
                    $post->set('publishedAt', NULL);
                    $post->set('updatedAt', NULL);
                    $post->set('updatedUserId', NULL);
                    if($this->updateArticle($post, true)) {
                        return $id;
                    }
                }
            }
            return false;
        }
    }

    /**
     * Update article
     *
     * @param  Parameter $post
     * @return bool (true if success)
     */
    public function updateArticle(Parameter $post, $justAdded = null)
    {
        if(!empty($_FILES['picture']['name']) and $justAdded === null) {
            $image = new Image('article', $_FILES['picture'], $post->get('id'));
            if($image->checkImage('article', $_FILES['picture'])) {
                $image->upload($_FILES['picture']);
            }
        }
        if($this->articleDAO->updateArticle($post)) {
            $this->alert->addSuccess("L'article a bien été modifié.");
            return true;   
        } else {
            $this->alert->addError("L'article n'a pas pu être modifié.");
            return false;
        }
    }
}