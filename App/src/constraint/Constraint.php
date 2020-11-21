<?php

namespace App\src\constraint;

class Constraint
{
    public function notBlank($name, $value)
    {
        if(empty($value)) {
            return "Le champ ".$name." saisi est vide";
        }
    }

    public function minLength($name, $value, $minSize)
    {
        if(strlen($value) < $minSize) {
            return "Le champ ".$name." doit contenir au moins ".$minSize." caractères";
        }
    }

    public function maxLength($name, $value, $maxSize)
    {
        if(strlen($value) > $maxSize) {
            return "Le champ ".$name." doit contenir au maximum ".$maxSize." caractères";
        }
    }

    public function allowCharacter($value)
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $value)) {
            return "Ne sont acceptés que les lettres sans accents et les chiffres.";
          }
    }

    public function validEmail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "Le format de l'adresse mail est invalide";
        }
    }

    public function isSame($data, $dataConfirm)
    {
        if($data !== $dataConfirm) {
            return "Les champs ne correspondent pas.";
        }
    }

}
