<?php

namespace App\src\constraint;

use App\src\blogFram\Alert;

/**
 * ImageValidation
 */
class ImageValidation
{
    /**
     * @var ImageConstraint
     */
    private $imageConstraint;
        
    /**
     * @var Alert
     */
    private $alert;

    const SIZE_MAX_AVATAR = 200000;                // Taille max en octets du fichier
    const WIDTH_MAX_AVATAR = 800;                  // Largeur max de l'image en pixels
    const HEIGHT_MAX_AVATAR = 800;                 // Hauteur max de l'image en pixels
    
    /**
     * Construct ImageValidation
     *
     * @return void
     */
    public function __construct()
    {
        $this->imageConstraint = new ImageConstraint();
        $this->alert = new Alert();
    }
    
    /**
     * Check avatar
     *
     * @param  array $file[]
     * @param  string $directory
     * @return bool (true if all good)
     */
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

        
    /**
     * Check image constraints
     *
     * @param  array $file[]
     * @param  string $directory
     * @param  int $sizeMax
     * @param  int $heightMax
     * @param  int $widthMax
     * @return bool (true if no error)
     */
    public function checkImageUpload($file, $directory, $sizeMax, $heightMax, $widthMax) 
    {
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
    
    /**
     * Check directory / Create directory
     *
     * @param  mixed $directory
     * @return void|string (string = error)
     */
    public function checkDirectory($directory)
    {
        if($this->imageConstraint->checkDirectory($directory)) {
            return $this->imageConstraint->checkDirectory($directory);
        }
    }
    
    /**
     * Check if true image (MIME = image/)
     *
     * @param  array $file[]
     * @return void|string (string = error)
     */
    public function checkImageTrue($file) {
        if($this->imageConstraint->checkImageTrue($file)) {
            return $this->imageConstraint->checkImageTrue($file);
        }
        
    }

    /**
     * Check if file name is not empty
     *
     * @param  array $file[]
     * @return void|string (string = error)
     */
    public function checkName($file) {
        if($this->imageConstraint->checkName($file)) {
            return $this->imageConstraint->checkName($file);
        }
    }

    /**
     * Check if extension file is allowed (self::IMAGE_EXTENSIONS)
     *
     * @param  array $file[]
     * @return void|string (string = error)
     */
    public function checkExtension($file) {
        if($this->imageConstraint->checkExtension($file)) {
            return $this->imageConstraint->checkExtension($file);
        }
    }

    /**
     * Check if image size is allowed
     *
     * @param  array $file[]
     * @param  int $sizeMax
     * @param  int $heightMax
     * @param  int $widthMax
     * @return void|string (string = error)
     */
    public function checkImageSize($file, $sizeMax, $heightMax, $widthMax) {
        if($this->imageConstraint->checkImageSize($file, $sizeMax, $heightMax, $widthMax)) {
            return $this->imageConstraint->checkImageSize($file, $sizeMax, $heightMax, $widthMax);
        }
    }

    /**
     * Check if $file['error'] === 0
     *
     * @param  array $file
     * @return void|string (string = error)
     */
    public function checkError($file) {
        if($this->imageConstraint->checkError($file)) {
            return $this->imageConstraint->checkError($file);
        }
    }

}
