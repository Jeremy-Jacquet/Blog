<?php

namespace App\src\entity;

class Category
{
    const MAIN_CATEGORY = 1;
    const ACTIVE_CATEGORY = NULL;
    const INACTIVE_CATEGORY = 0;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

        /**
     * @var string
     */
    private $sentence;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var int
     */
    private $status;

    /*
    |--> GETTERS <--|
    */

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSentence()
    {
        return $this->sentence;
    }

    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /*
    |--> SETTERS <--|
    */

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @param string $sentence
     */
    public function setSentence($sentence)
    {
        $this->sentence = $sentence;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}