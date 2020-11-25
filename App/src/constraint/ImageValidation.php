<?php

namespace App\src\constraint;

use App\src\blogFram\Alert;

class ImageValidation extends Validation
{
    private $constraint;
    private $alert;

    const SIZE_MAX_AVATAR = 200000;                // Taille max en octets du fichier
    const WIDTH_MAX_AVATAR = 800;                  // Largeur max de l'image en pixels
    const HEIGHT_MAX_AVATAR = 800;                 // Hauteur max de l'image en pixels

    public function __construct()
    {
        $this->constraint = new ImageConstraint();
        $this->alert = new Alert();
    }

    public function checkAvatar($file, $directory)
    {
        $validate = $this->checkImageUpload(
            $file, 
            $directory,
            self::SIZE_MAX_AVATAR, 
            self::HEIGHT_MAX_AVATAR, 
            self::WIDTH_MAX_AVATAR
        );
        return (!$validate)? false : true;
    }

    public function checkImageUpload($file, $directory, $sizeMax, $heightMax, $widthMax) {
        $error = 0;
        if($this->checkDirectory($directory)) {
            $this->alert->addError($this->checkDirectory($directory));
            $error++;
        }
        if($this->checkImageTrue($file)) {
            $this->alert->addError($this->checkImageTrue($file));
            $error++;
        }
        if($this->checkName($file)) {
            $this->alert->addError($this->checkName($file));
            $error++;
        }
        if($this->checkExtension($file)) {
            $this->alert->addError($this->checkExtension($file));
            $error++;
        }
        if($this->checkImageSize($file, $sizeMax, $heightMax, $widthMax)) {
            $this->alert->addError($this->checkImageSize($file, $sizeMax, $heightMax, $widthMax));
            $error++;
        }
        if($this->checkError($file)) {
            $this->alert->addError($this->checkError($file));
            $error++;
        }
        return ($error)? false : true;  
    }

    public function checkDirectory($directory)
    {
        if($this->constraint->checkDirectory($directory)) {
            return $this->constraint->checkDirectory($directory);
        }
    }

    public function checkImageTrue($file) {
        if($this->constraint->checkImageTrue($file)) {
            return $this->constraint->checkImageTrue($file);
        }
        
    }

    public function checkName($file) {
        if($this->constraint->checkName($file)) {
            return $this->constraint->checkName($file);
        }
    }

    public function checkExtension($file) {
        if($this->constraint->checkExtension($file)) {
            return $this->constraint->checkExtension($file);
        }
    }

    public function checkImageSize($file, $sizeMax, $heightMax, $widthMax) {
        if($this->constraint->checkImageSize($file, $sizeMax, $heightMax, $widthMax)) {
            return $this->constraint->checkImageSize($file, $sizeMax, $heightMax, $widthMax);
        }
    }

    public function checkError($file) {
        if($this->constraint->checkError($file)) {
            return $this->constraint->checkError($file);
        }
    }

}
