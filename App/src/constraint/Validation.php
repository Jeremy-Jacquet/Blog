<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;

class Validation
{
    public function validateInput($category, Parameter $post)
    {
        if($category === 'user') {
            $userValidation = new UserValidation();
            $validate = $userValidation->checkField($post);
            return $validate;
        }
    }

    public function validateImage($category, $file, $directory)
    {
        if($category === 'avatar') {
            $imageValidation = new ImageValidation();
            $validate = $imageValidation->checkAvatar($file, $directory);
            return $validate;
        }
    }

}