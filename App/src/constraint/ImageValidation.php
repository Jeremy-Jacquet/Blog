<?php

namespace App\src\constraint;

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

    const SIZE_MAX_AVATAR = 200000;                 // Taille max en octets du fichier
    const WIDTH_MAX_AVATAR = 800;                   // Largeur max de l'image en pixels
    const HEIGHT_MAX_AVATAR = 800;                  // Hauteur max de l'image en pixels
    const SIZE_MAX_CATEGORY_IMAGE = 200000;
    const WIDTH_MAX_CATEGORY_IMAGE = 800;
    const HEIGHT_MAX_CATEGORY_IMAGE = 800;
    const SIZE_MAX_ARTICLE_IMAGE = 200000;
    const WIDTH_MAX_ARTICLE_IMAGE = 800;
    const HEIGHT_MAX_ARTICLE_IMAGE = 800;
    
        
    /**
     * construct ImageValidation
     *
     * @param  Alert $alert
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
        $this->imageConstraint = new ImageConstraint($alert);
    }
         
    /**
     * check image constraints
     *
     * @param  array $file
     * @param  string $directory
     * @param  int $sizeMax
     * @param  int $heightMax
     * @param  int $widthMax
     * @return bool
     */
    public function checkImageUpload($file, $directory, $sizeMax, $heightMax, $widthMax) 
    {
        $error = 0;
        $this->createDirectory($directory);
        $error = (!$this->checkImageTrue($file))? $error +1 : $error;
        $error = (!$this->checkName($file))? $error +1 : $error;
        $error = (!$this->checkExtension($file))? $error +1 : $error;
        $error = (!$this->checkImageSize($file, $sizeMax, $heightMax, $widthMax))? $error +1 : $error;
        $error = (!$this->checkError($file))? $error +1 : $error;
        return ($error > 0)? false : true;  
    }

    /**
     * check avatar
     *
     * @param  array $file
     * @param  string $directory
     * @return bool
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
        return ($validate)? true : false;
    }

    /**
     * check article image
     *
     * @param  array $file
     * @param  string $directory
     * @return bool
     */
    public function checkArticleImage($file, $directory)
    {
        $validate = $this->checkImageUpload(
            $file, 
            $directory,
            self::SIZE_MAX_ARTICLE_IMAGE, 
            self::HEIGHT_MAX_ARTICLE_IMAGE, 
            self::WIDTH_MAX_ARTICLE_IMAGE
        );
        return ($validate)? true : false;
    }

    /**
     * check category image
     *
     * @param  array $file
     * @param  string $directory
     * @return bool
     */
    public function checkCategoryImage($file, $directory)
    {
        $validate = $this->checkImageUpload(
            $file, 
            $directory,
            self::SIZE_MAX_CATEGORY_IMAGE, 
            self::HEIGHT_MAX_CATEGORY_IMAGE, 
            self::WIDTH_MAX_CATEGORY_IMAGE
        );
        return ($validate)? true : false;
    }
    
    /**
     * create directory
     *
     * @param  string $directory
     * @return true
     */
    private function createDirectory($directory) 
    {
        return $this->imageConstraint->createDirectory($directory);
    }
    
    /**
     * Check if true image (MIME = image/)
     *
     * @param  array $file
     * @return bool
     */
    private function checkImageTrue($file) 
    {
        return $this->imageConstraint->checkImageTrue($file);
        
    }

    /**
     * check file name is not empty
     *
     * @param  array $file
     * @return bool
     */
    private function checkName($file) 
    {
        return $this->imageConstraint->checkName($file);
    }

    /**
     * check file extension
     *
     * @param  array $file
     * @return bool
     */
    private function checkExtension($file) 
    {
        return $this->imageConstraint->checkExtension($file);
    }

    /**
     * check image size
     *
     * @param  array $file
     * @param  int $sizeMax
     * @param  int $heightMax
     * @param  int $widthMax
     * @return bool
     */
    private function checkImageSize($file, $sizeMax, $heightMax, $widthMax) 
    {
        return $this->imageConstraint->checkImageSize($file, $sizeMax, $heightMax, $widthMax);
    }

    /**
     * check if $file['error'] === 0
     *
     * @param  array $file
     * @return bool
     */
    private function checkError($file) 
    {
        return $this->imageConstraint->checkError($file);
    }

}
