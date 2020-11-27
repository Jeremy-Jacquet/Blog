<?php

namespace App\src\constraint;

/**
 * CommentConstraint
 */
class CommentConstraint
{
    /**
     * Check if comment is not empty
     *
     * @param  string $content
     * @return void|string (string = error)
     */
    public function notBlank($content)
    {
        if(empty($content)) {
            return "Le commentaire ne doit pas être vide";
        }
    }

    /**
     * Check if input min length is respected
     *
     * @param  string $content
     * @param  int $minSize
     * @return void|string (string = error)
     */
    public function minLength($content, $minSize)
    {
        if(strlen($content) < $minSize) {
            return "Le commentaire doit contenir au moins $minSize caractères";
        }
    }
    
    /**
     * Check if input max length is respected
     *
     * @param  mixed $content
     * @param  mixed $maxSize
     * @return void|string (string = error)
     */
    public function maxLength($content, $maxSize)
    {
        if(strlen($content) > $maxSize) {
            return "Le commentaire doit contenir au maximum $maxSize caractères";
        }
    }

    /*
    public function allowWord($content){}
    */
}