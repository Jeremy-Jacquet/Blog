<?php

namespace App\src\entity;

class Category
{
    const STATUS = [
        'active' => 1,
        'inactive' => 0,
        'main' => 2
    ];

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

    /**
     * @var string
     */
    private $statusName;

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

    /**
     * @return string
     */
    public function getStatusName()
    {
        return $this->statusName;
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

    /**
     * @param string $statusName
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;
    }
}