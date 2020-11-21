<?php

namespace App\src\constraint;

class ImageConstraint
{
    private $tabExt = array('jpg','gif','png','jpeg');
    private $infosImg = array();

    public function checkDirectory($directory)
    {
        if(!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function checkImageTrue($file){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mtype = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if(!strpos($mtype, 'image/') === 0) {
            return "Le fichier n'est pas une image.";
        }
    }

    public function checkName($file)
    {
        if(empty($file['name'])) {
            return "Le nom de votre image n'est pas reconnu.";
        }
    }

    public function checkExtension($file)
    {
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        if(!in_array(strtolower($extension), $this->tabExt)) {
            return "L'extension de l'image n'est pas reconnue.";
        }
    }

    public function checkImageSize($file, $sizeMax, $heightMax, $widthMax)
    {
        $this->infosImg = getimagesize($file['tmp_name']);
        if(filesize($file['tmp_name']) >= $sizeMax) {
            return "Les dimensions de l'image ne sont pas supportées.";
        }
        /*
        if(!($this->infosImg[0] <= $widthMax) 
        OR !($this->infosImg[1] <= $heightMax) 
        OR !(filesize($file['tmp_name']) <= $sizeMax)) {
            return "Les dimensions de l'image ne sont pas supportées.";
        }
        */
    }

    public function checkError($file)
    {
        if(isset($file['error']) AND $file['error'] !== UPLOAD_ERR_OK) {
            return "Une erreur est survenue.";
        }
    }

}
