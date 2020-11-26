<?php

namespace App\src\constraint;

/**
 * InputConstraint
 */
class InputConstraint
{    
    /**
     * Check if input is not empty
     *
     * @param  string $name
     * @param  string $value
     * @return void|string (string = error)
     */
    public function notBlank($name, $value)
    {
        if(empty($value)) {
            return "Le champ $name saisi est vide";
        }
    }
    
    /**
     * Check if input min length is respected
     *
     * @param  string $name
     * @param  string $value
     * @param  int $minSize
     * @return void|string (string = error)
     */
    public function minLength($name, $value, $minSize)
    {
        if(strlen($value) < $minSize) {
            return "Le champ $name doit contenir au moins $minSize caractères";
        }
    }
    
    /**
     * Check if input max length is respected
     *
     * @param  mixed $name
     * @param  mixed $value
     * @param  mixed $maxSize
     * @return void|string (string = error)
     */
    public function maxLength($name, $value, $maxSize)
    {
        if(strlen($value) > $maxSize) {
            return "Le champ $name doit contenir au maximum $maxSize caractères";
        }
    }
    
    /**
     * Check if input is allowed characters
     *
     * @param  string $value
     * @return void|string (string = error)
     */
    public function allowCharacter($value)
    {
        if (!preg_match("/^[a-zA-Z0-9]*$/", $value)) {
            return "Ne sont acceptés que les lettres sans accents et les chiffres.";
          }
    }
    
    /**
     * Check if email is valid
     *
     * @param  string $value
     * @return void|string (string = error)
     */
    public function validEmail($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return "Le format de l'adresse mail est invalide";
        }
    }
    
    /**
     * Check if the two values are identicals
     *
     * @param  string $data
     * @param  string $dataConfirm
     * @return void|string (string = error)
     */
    public function isSame($data, $dataConfirm)
    {
        if($data !== $dataConfirm) {
            return "Les champs ne correspondent pas.";
        }
    }

}
