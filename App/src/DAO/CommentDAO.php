<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\blogFram\Parameter;
use App\src\entity\Comment;
use \PDO;

/**
 * CommentDAO
 */
class CommentDAO extends DAO
{    
    /**
     * hydrate comment object
     *
     * @param  mixed $row
     * @return Comment
     */
    private function buildObject($row)
    {
        $comment = new Comment();
        $comment->setId($row['id']);
        $comment->setContent($row['content']);
        $comment->setArticleId($row['article_id']);
        $comment->setUserId($row['user_id']);
        $comment->setCreatedAt($row['created_at']);
        $comment->setStatus($row['status']);
        if($row['status'] == 0) {
            $comment->setStatusName('inactive');
        } elseif($row['status'] == 1) {
            $comment->setStatusName('active');
        }
        $comment->setUserPseudo($row['pseudo']);
        return $comment;
    }

    public function addComment($post)
    {
        $sql = "INSERT INTO `comment` (`content`, `article_id`, `user_id`, `created_at`, `status`) 
                VALUES (:content, :article_id, :user_id, :created_at, :status)";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':article_id', $post->get('article_id'), PDO::PARAM_INT);
        $result->bindValue(':user_id', $post->get('user_id'), PDO::PARAM_INT);
        $result->bindValue(':created_at', $post->get('created_at'), PDO::PARAM_STR);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->execute();
        $newCommentId = $this->checkConnection()->lastInsertId();
        $result->closeCursor();
        return $newCommentId;
    }

    public function updateComment($post)
    {
        if(!$this->checkCommentId($post->get('id'))) {
            return false;
        }
        $sql = "UPDATE `comment` SET `status` = :status WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function deleteComment($post)
    {
        if(!$this->checkCommentId($post->get('id'))) {
            return false;
        }
        $sql = "DELETE FROM `comment` WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function getComments($attributes, $limit = null, $start = null) 
    {
        $sql = "SELECT c.*, u.pseudo 
        FROM comment c 
        INNER JOIN user u ON u.id = c.user_id ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('comment', $attributes);
        }
        $sql .= " ORDER BY id DESC";
        if($limit !== null AND $start !== null) {
            $sql .= ' LIMIT '.$limit.' OFFSET '.$start;
        }
        if($attributes !== 'all') {
            $result = $this->checkConnection()->prepare($sql);
        } else {
            $result = $this->checkConnection()->query($sql);
        }
        if($attributes !== 'all') {
            foreach ($attributes as $attribute){
                $result->bindValue(':'.$attribute['name'], $attribute['value'], $this->getParameter($attribute['parameter']));
            }
        }
        $result->execute();
        $comments = [];
        foreach ($result as $row){
            $comments[$row['id']] = $this->buildObject($row);
        }
        $result->closeCursor();
        return ($comments)? $comments : false;
    }

    public function checkCommentId($commentId)
    {
        $sql = "SELECT COUNT(*) FROM `comment` WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $commentId, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch();
        $result->closeCursor();
        return ($count[0] > 0)? true : false;
    }

    /**
     * count comments
     *
     * @param  array $attributes
     * @return int
     */
    public function countComments($attributes)
    {
        $sql = "SELECT COUNT(*) FROM comment c ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('comment', $attributes);
            $result = $this->checkConnection()->prepare($sql);
        } else {
            $result = $this->checkConnection()->query($sql);
        }
        if($attributes !== 'all') {
            foreach ($attributes as $attribute){
                $result->bindValue(':'.$attribute['name'], $attribute['value'], $this->getParameter($attribute['parameter']));
            }
        }
        $result->execute();
        $count = $result->fetchColumn();
        $result->closeCursor();
        return $count;
    }

}
