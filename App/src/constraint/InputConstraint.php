<?php

namespace App\src\constraint;

use App\src\blogFram\Alert;

/**
 * InputConstraint
 */
class InputConstraint
{        
    /**
     * @var Alert
     */
    private $alert;
        
    /**
     * construct InputConstraint
     *
     * @param  Alert $alert
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
    }
    
    /**
     * traduce
     *
     * @param  mixed $inputName
     * @return string
     */
    public function traduce($inputName)
    {
        $word = $inputName;
        if($inputName === 'password' OR $inputName === 'password2'){
            $word = 'mot de passe';
        } elseif($inputName === 'content'){
            $word = 'contenu';
        } elseif($inputName === 'comment'){
            $word = 'commentaire';
        }
        return $word;
    }
    
    /**
     * check if input is not empty
     *
     * @param  string $inputName
     * @param  string $value
     * @return bool
     */
    public function notBlank($inputName, $value)
    {
        $inputName = $this->traduce($inputName);
        if(empty($value)) {
            $this->alert->set('error', 'normal', 'main',  "Le champ \"$inputName\" saisi est vide");
        }
        return (empty($value))? false : true;
    }
    
    /**
     * check min length
     *
     * @param  string $inputName
     * @param  string $value
     * @param  int $minSize
     * @return bool
     */
    public function minLength($inputName, $value, $minSize)
    {
        $inputName = $this->traduce($inputName);
        if(strlen($value) < $minSize) {
            $this->alert->set('error', 'normal', 'main',  "Le champ \"$inputName\" doit contenir au moins $minSize caractères");
        }
        return (strlen($value) < $minSize)? false : true;
    }
    
    /**
     * check input max length
     *
     * @param  string $inputName
     * @param  string $value
     * @param  int $maxSize
     * @return bool
     */
    public function maxLength($inputName, $value, $maxSize)
    {
        $inputName = $this->traduce($inputName);
        if(strlen($value) > $maxSize) {
            $this->alert->set('error', 'normal', 'main',  "Le champ \"$inputName\" doit contenir au maximum $maxSize caractères");
        }
        return (strlen($value) > $maxSize)? false : true;
    }
    
    /**
     * check allowed characters
     * Add error message
     *
     * @param  string $value
     * @return bool
     */
    public function allowCharacter($value)
    {
        if(!preg_match("/^[a-zA-Z0-9]*$/", $value)) {
            $this->alert->set('error', 'normal', 'main',  "Ne sont acceptés que les lettres sans accents et les chiffres.");
        }
        return (!preg_match("/^[a-zA-Z0-9]*$/", $value))? false : true;
    }
    
    /**
     * check if email is valid
     *
     * @param  string $value
     * @return bool
     */
    public function validEmail($value)
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->alert->set('error', 'normal', 'main',  "Le format de l'adresse mail est invalide");
        }
        return (!filter_var($value, FILTER_VALIDATE_EMAIL))?false : true;
    }
    
    /**
     * check if is same
     *
     * @param  string $data
     * @param  string $dataToConfirm
     * @return bool
     */
    public function checkIsSame($data, $dataToConfirm)
    {
        if($data !== $dataToConfirm) {
            $this->alert->set('error', 'normal', 'main',  "Les champs ne correspondent pas.");
        }
        return ($data !== $dataToConfirm)? false : true;
    }

    

}
