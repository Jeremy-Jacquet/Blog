<?php

namespace App\src\entity;

class Comment
{
    const STATUS = [
        'active' => 1,
        'inactive' => 0,
        'pending' => 2
    ];

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $content;

        /**
     * @var int
     */
    private $articleId;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $createdAt;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $statusName;

    /**
     * @var string
     */
    private $userPseudo;

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
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

    /**
     * @return string
     */
    public function getUserPseudo()
    {
        return $this->userPseudo;
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
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @param int $articleId
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param string $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @param int $statusName
     */
    public function setStatusName($statusName)
    {
        $this->statusName = $statusName;
    }

    /**
     * @param string $userPseudo
     */
    public function setUserPseudo($userPseudo)
    {
        $this->userPseudo = $userPseudo;
    }
}