<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Image;

class CategoryController extends Controller
{
    public function addCategory(Parameter $post)
    {
        if($this->validation->validateInput('category', $post)) {
            $post->set('filename', 'tmp');
            $id = $this->categoryDAO->addCategory($post);
            $post->set('id', $id);
            $image = new Image('category', $_FILES['picture'], $post->get('id'));
            if($image->checkImage('category', $_FILES['picture'], $image::TARGET_CATEGORY)) {
                if($image->upload($_FILES['picture'])) {
                    $post->set('filename', $image->getFilename());
                    if($this->updateCategory($post)) {
                        return $id;
                    }
                }
            }
            return false;
        }
        
    }

    public function updateCategory(Parameter $post)
    {
        if($this->categoryDAO->updateCategory($post)) {
            $this->alert->addSuccess("La catégorie a bien été modifiée.");
            return true;   
        } else {
            $this->alert->addError("La catégorie n'a pas pu être modifié.");
            return false;
        }
    }
}