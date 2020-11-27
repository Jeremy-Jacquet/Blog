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
            return $validate;
        } elseif($category === 'comment') {
            $commentValidation = new CommentValidation();
            $validate = $commentValidation->checkComment($post->get('comment'));
            return $validate;
        }
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
        if($category === 'avatar') {
            $imageValidation = new ImageValidation();
            $validate = $imageValidation->checkAvatar($file, $directory);
            return $validate;
        }
    }

}