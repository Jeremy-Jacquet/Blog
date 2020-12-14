<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;

/**
 * Validation
 */
class Validation
{    
    /**
     * Check if input is valid
     *
     * @param  string $category (ex: user, comment)
     * @param  Parameter $post
     * @return bool (true if all good)
     */
    public function validateInput($category, Parameter $post)
    {
        if($category === 'user') {
            $userValidation = new UserValidation();
            $validate = $userValidation->checkField($post);
        } elseif($category === 'comment') {
            $commentValidation = new CommentValidation();
            $validate = $commentValidation->checkComment($post->get('content'));
        } elseif($category === 'category') {
            $categoryValidation = new CategoryValidation();
            $validate = $categoryValidation->checkField($post);
        } elseif($category === 'article') {
            $articleValidation = new ArticleValidation();
            $validate = $articleValidation->checkField($post);
        }
        return $validate;
    }
    
    /**
     * Check if image is valid
     *
     * @param  string $category (ex: avatar)
     * @param  array $file[]
     * @param  string $directory
     * @return bool (true if all good)
     */
    public function validateImage($category, $file, $directory)
    {
        
        $imageValidation = new ImageValidation();
        if($category === 'avatar') {
            $validate = $imageValidation->checkAvatar($file, $directory);
        } elseif($category === 'article') {
            $validate = $imageValidation->checkArticleImage($file, $directory);
        }
        return $validate;
    }

}