<?php

namespace App\src\constraint;

class Validation
{
    public function validate($data, $name)
    {
        if ($name === 'User') {
            $userValidation = new UserValidation();
            $errors = $userValidation->checkField($data);
            return $errors;
        }
    }

}