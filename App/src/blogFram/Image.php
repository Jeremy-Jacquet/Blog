<?php

namespace App\src\blogFram;

use App\src\constraint\Validation;

/**
 * Image
 */
class Image
{
    const TARGET_AVATAR = "../public/img/avatar/"; 
    const TARGET_CATEGORY = "../public/img/category/"; 
    const TARGET_ARTICLE = "../public/img/article/"; 
    
    /**
     * @var Validation
     */
    private $validation;    

    /**
     * @var string
     */
    private $filename;   

    /**
     * @var string
     */
    private $imagePath;
    
    /**
     * construct Image
     *
     * @param  string $imageOf ex: avatar, article, category
     * @param  array $file
     * @param  string $name
     * @return Image
     */
    public function __construct($imageOf, $file, $name)
    {
        $this->validation = new Validation($_SESSION);
        $this->setFilename($file, $name);
        $this->setImagePath($imageOf);
        return $this;
    }
    
    /**
     * check image
     *
     * @param  string $imageOf ex: avatar, article, category
     * @param  array $file
     * @return bool 
     */
    public function checkImage($imageOf, $file)
    {
        if($imageOf === 'avatar') {
            $validate = $this->validation->checkImageValidity($imageOf, $file, self::TARGET_AVATAR);
        } elseif($imageOf === 'category') {
            $validate = $this->validation->checkImageValidity($imageOf, $file, self::TARGET_CATEGORY);
        } elseif($imageOf === 'article') {
            $validate = $this->validation->checkImageValidity($imageOf, $file, self::TARGET_ARTICLE);
        }
        return ($validate)? true : false;
    }
    
    /**
     * upload image
     *
     * @param  array $file
     * @return bool
     */
    public function upload($file)
    {
        return (move_uploaded_file($file['tmp_name'], $this->imagePath))? true : false;
    }
    
    /**
     * set filename
     *
     * @param  array $file
     * @param  string $name
     * @return void
     */
    private function setFilename($file, $name)
    {
        if($file AND $name) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $this->filename = $name.'.'.$extension;
        }

    }
    
    /**
     * set image path
     *
     * @param  string $category ex: avatar, article, category
     * @return void
     */
    private function setImagePath($category)
    {
        if($category === 'avatar') {
            $this->imagePath = self::TARGET_AVATAR.$this->filename;
        } elseif($category === 'category') {
            $this->imagePath = self::TARGET_CATEGORY.$this->filename;
        } elseif($category === 'article') {
            $this->imagePath = self::TARGET_ARTICLE.$this->filename;
        }
    }
    
    /**
     * Get file name
     *
     * @return string $this->filename
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    /**
     * Get image path
     *
     * @return string $this->imagePath
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
    
}
