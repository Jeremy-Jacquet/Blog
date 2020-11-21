<?php

namespace App\src\blogFram;

use App\src\constraint\Validation;

class Image
{
    const TARGET_AVATAR = "../public/img/avatar/"; 

    private $validation;
    private $filename;
    private $imagePath;

    public function __construct($category, $file, $name)
    {
        $this->validation = new Validation();
        $this->setFilename($file, $name);
        $this->setImagePath($category);
    }

    public function checkImage($category, $file)
    {
        if($category = 'avatar') {
            $validate = $this->validation->validateImage($category, $file, self::TARGET_AVATAR);
        }
        return ($validate)? true : false;
    }

    public function upload($file)
    {
        if(move_uploaded_file($file['tmp_name'], $this->imagePath)) {
            return true;                
        } else {
            return false;
        }
    }

    public function setFilename($file, $name)
    {
        if($file AND $name) {
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $this->filename = $name.'.'.$extension;
        }
        
    }

    public function setImagePath($category)
    {
        if($category === 'avatar') {
            $this->imagePath = self::TARGET_AVATAR.$this->filename;
        }
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getImagePath()
    {
        return $this->imagePath;
    }
    
}
