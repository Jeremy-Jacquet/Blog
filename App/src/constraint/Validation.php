<?php

namespace App\src\constraint;

use App\src\blogFram\Parameter;

/**
 * Validation
 */
class Validation
{        
    /**
     * @var Alert
     */
    private $alert;
        
    /**
     * construct Validation
     *
     * @param  Alert $alert
     * @return void
     */
    public function __construct($alert)
    {
        $this->alert = $alert;
    }

    /**
     * check input validity
     *
     * @param  string $entity   ex: user, comment...
     * @param  Parameter $post
     * @return bool
     */
    public function checkInputValidity($entity, $post)
    {
        if($entity === 'user') {
            $userValidation = new UserValidation($this->alert);
            $isValidated = $userValidation->checkField($post);
        } elseif($entity === 'comment') {
            $commentValidation = new CommentValidation($this->alert);
            $isValidated = $commentValidation->checkField($post);
        } elseif($entity === 'category') {
            $categoryValidation = new CategoryValidation($this->alert);
            $isValidated = $categoryValidation->checkField($post);
        } elseif($entity === 'article') {
            $articleValidation = new ArticleValidation($this->alert);
            $isValidated = $articleValidation->checkField($post);
        } elseif($entity === 'contact') {            
            $userValidation = new UserValidation($this->alert);
            $contactValidation = new ContactValidation($this->alert);
            $isValidatedUser = $userValidation->checkField($post);
            $isValidatedComment = $contactValidation->checkField($post);
            $isValidated = (!$isValidatedUser OR !$isValidatedComment)? false : true;
        }
        return $isValidated;
    }
    
    /**
     * check image validity
     *
     * @param  string $imageOf     ex: avatar, category, article
     * @param  array $file
     * @param  string $directory
     * @return bool
     */
    public function checkImageValidity($imageOf, $file, $directory)
    {
        
        $imageValidation = new ImageValidation($this->alert);
        if($imageOf === 'avatar') {
            $isValidated = $imageValidation->checkAvatar($file, $directory);
        } elseif($imageOf === 'category') {
            $isValidated = $imageValidation->checkCategoryImage($file, $directory);
        } elseif($imageOf === 'article') {
            $isValidated = $imageValidation->checkArticleImage($file, $directory);
        }
        return $isValidated;
    }

}