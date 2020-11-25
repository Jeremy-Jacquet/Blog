<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Comment;

class CommentDAO extends DAO
{
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setContent($row['content']);
        $comment->setArticleId($row['article_id']);
        $comment->setUserId($row['user_id']);
        $comment->setCreatedAt($row['created_at']);
        $comment->setStatus($row['status']);
        $comment->setUserPseudo($row['pseudo']);
        return $comment;
    }

    public function getComments()
    {
        $sql = "SELECT c.*, u.pseudo 
        FROM comment c 
        INNER JOIN user u ON u.id = c.user_id";
        $result = $this->checkConnection()->query($sql);
        $result->execute();
        $comments = [];
        foreach ($result as $row){
            $comments[$row['id']] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $comments;
    }

}
