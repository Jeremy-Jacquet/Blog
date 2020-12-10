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
     * Construct Image
     *
     * @param  string $category (ex: avatar)
     * @param  array $file[]
     * @param  string $name
     * @return void
     */
    public function __construct($category, $file, $name)
    {
        $this->validation = new Validation();
        $this->setFilename($file, $name);
        $this->setImagePath($category);
    }
    
    /**
     * Check image
     *
     * @param  string $category (ex: avatar)
     * @param  array $file[]
     * @return bool (true if all good)
     */
    public function checkImage($category, $file)
    {
        if($category = 'avatar') {
            $validate = $this->validation->validateImage($category, $file, self::TARGET_AVATAR);
        } elseif( $category = "category") {
            $validate = $this->validation->validateImage($category, $file, self::TARGET_CATEGORY);
        }
        return ($validate)? true : false;
    }
    
    /**
     * Upload image
     *
     * @param  array $file[]
     * @return bool (true if image correctly uploaded)
     */
    public function upload($file)
    {
        if(move_uploaded_file($file['tmp_name'], $this->imagePath)) {
            return true;                
        }
        return false;
    }
    
    /**
     * Set filename
     *
     * @param  array $file[]
     * @param  string $name
     * @return void
     */
    public function setFilename($file, $name)
    {
        if($file AND $name) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $this->filename = $name.'.'.$extension;
        }

    }
    
    /**
     * Set image path
     *
     * @param  string $category (ex: avatar)
     * @return void
     */
    public function setImagePath($category)
    {
        if($category === 'avatar') {
            $this->imagePath = self::TARGET_AVATAR.$this->filename;
        } elseif($category === "category") {
            $this->imagePath = self::TARGET_CATEGORY.$this->filename;
        }
    }
    
    /**
     * Get file name
     *
     * @return string private filename
     */
    public function getFilename()
    {
        return $this->filename;
    }
    
    /**
     * Get image path
     *
     * @return string private imagePath
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }
    
}
