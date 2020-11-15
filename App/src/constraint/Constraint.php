<?php

namespace App\src\constraint;

class Constraint
{
    public function notBlank($name, $value)
    {
        if(empty($value)) {
            return 'Le champ '.$name.' saisi est vide';
        }
    }

    public function minLength($name, $value, $minSize)
    {
        if(strlen($value) < $minSize) {
            return 'Le champ '.$name.' doit contenir au moins '.$minSize.' caractères';
        }
    }

    public function maxLength($name, $value, $maxSize)
    {
        if(strlen($value) > $maxSize) {
            return 'Le champ '.$name.' doit contenir au maximum '.$maxSize.' caractères';
        }
    }

    public function samePassword($password, $password2)
    {
        if($password !== $password2) {
            return 'Les mots de passe ne correspondent pas.';
        }
    }

    /*
    public function allowedCharacters($string)
    {
        if(!preg_match('/[a-zA-Z0-9]+/', $string)) {
            return 'Les caractères spéciaux ne sont pas autorisés';
        };
    }
    */
}