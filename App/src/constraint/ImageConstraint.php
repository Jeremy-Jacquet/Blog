<?php

namespace App\src\constraint;

use App\src\blogFram\Alert;

/**
 * ImageConstraint
 */
class ImageConstraint
{
    const IMAGE_EXTENSIONS = ['jpg','gif','png','jpeg'];
    
    /**
     * @var Alert
     */
    private $alert;

    /**
     * @var array
     */
    //private $infosImg = [];
    
    /**
     * construct ImageConstraint
     *
     * @param  Alert $alert
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
    }
    
    /**
     * check|create directory
     *
     * @param  string $directory
     * @return true
     */
    public function createDirectory($directory)
    {
        if(!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
        return true;
    }
    
    /**
     * check if true image (MIME = image/)
     *
     * @param  array $file
     * @return bool
     */
    public function checkImageTrue($file)
    {
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($fileInfo, $file['tmp_name']);
        finfo_close($fileInfo);
        if(strpos($mimeType, 'image/') !== 0) {
            $this->alert->set('error', 'normal', 'main',  "Le fichier n'est pas une image.");
        }
        return (strpos($mimeType, 'image/') !== 0)? false : true;
    }
    
    /**
     * check if file name is not empty
     *
     * @param  array $file
     * @return bool
     */
    public function checkName($file)
    {
        if(empty($file['name'])) {
            $this->alert->set('error', 'normal', 'main',  "Le nom de votre image n'est pas reconnu.");
        }
        return (empty($file['name']))? false : true;
    }
    
    /**
     * check file extension
     *
     * @param  array $file
     * @return bool
     */
    public function checkExtension($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if(!in_array(strtolower($extension), self::IMAGE_EXTENSIONS)) {
            $this->alert->set('error', 'normal', 'main',  "L'extension de l'image n'est pas reconnue.");
        }
        return (!in_array(strtolower($extension), self::IMAGE_EXTENSIONS))? false :true;
    }
    
    /**
     * check image size
     *
     * @param  array $file
     * @param  int $sizeMax
     * @return bool
     */
    public function checkImageSize($file, $sizeMax)
    {
        $this->infosImg = getimagesize($file['tmp_name']);
        if(filesize($file['tmp_name']) >= $sizeMax) {
            $this->alert->set('error', 'normal', 'main',  "Les dimensions de l'image ne sont pas supportées.");
        }
        return (filesize($file['tmp_name']) >= $sizeMax)? false : true;
        /*
        if(!($this->infosImg[0] <= $widthMax) 
        OR !($this->infosImg[1] <= $heightMax) 
        OR !(filesize($file['tmp_name']) <= $sizeMax)) {
            return "Les dimensions de l'image ne sont pas supportées.";
        }
        */
    }
    
    /**
     * Check if $file['error'] === 0
     *
     * @param  array $file
     * @return bool
     */
    public function checkError($file)
    {
        if(isset($file['error']) AND $file['error'] !== UPLOAD_ERR_OK) {
            $this->alert->set('error', 'normal', 'main',  "Une erreur est survenue.");
        }
        return (isset($file['error']) AND $file['error'] !== UPLOAD_ERR_OK)? false : true;
    }

}
