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
     * Hydrate comment object
     *
     * @param  mixed $row
     * @return Comment $comment
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
        $comment->setUserPseudo($row['pseudo']);
        return $comment;
    }
    
    /**
     * Get all comments
     *
     * @return array [Objects]
     */
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
    
    /**
     * Add comment in database
     *
     * @param  Parameter $post
     * @param  string $date
     * @return bool
     */
    public function addComment(Parameter $post, $date)
    {
        $sql = "INSERT INTO `comment` (`content`, `article_id`, `user_id`, `created_at`, `status`) 
                VALUES (:content, :article_id, :user_id, :created_at, :status)";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':article_id', $post->get('articleId'), PDO::PARAM_INT);
        $result->bindValue(':user_id', $post->get('userId'), PDO::PARAM_INT);
        $result->bindValue(':created_at', $date, PDO::PARAM_STR);
        $result->bindValue(':status', NULL, PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return ($result)? true : false;
    }
    
    /**
     * Update comment
     *
     * @param  Parameter $post
     * @param  int $status
     * @return bool
     */
    public function updateComment(Parameter $post, $status)
    {
        if(!$this->checkComment($post->get('id'))) {
            return false;
        }
        $sql = "UPDATE comment SET `status` = :status WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':status', $status, PDO::PARAM_INT);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }
    
    /**
     * Delete comment
     *
     * @param  Parameter $post
     * @return bool (false if commment id doesn't exist)
     */
    public function deleteComment(Parameter $post)
    {
        if(!$this->checkComment($post->get('id'))) {
            return false;
        }
        $sql = "DELETE comment WHERE id = :id";
        $result = $this->checkConnection->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    /**
     * Check comment id
     *
     * @param  int $id
     * @return bool (true if comment id exists)
     */
    public function checkComment($id)
    {
        $sql = "SELECT COUNT(*) FROM comment WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return ($count > 0)? true : false;
    }

}
