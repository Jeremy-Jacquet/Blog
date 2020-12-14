<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Article;
use App\src\blogFram\Parameter;
use \PDO;

/**
 * ArticleDAO
 */
class ArticleDAO extends DAO
{    
    /**
     * Hydrate article object
     *
     * @param  mixed $row
     * @return Article $article
     */
    private function buildObject($row)
    {
        $article = new Article();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setSentence($row['sentence']);
        $article->setContent($row['content']);
        $article->setFilename($row['filename']);
        $article->setUserId($row['user_id']);
        $article->setCreatedAt($row['created_at']);
        $article->setPublishedAt($row['published_at']);
        $article->setUpdatedAt($row['updated_at']);
        $article->setUpdatedUserId($row['updated_user_id']);
        $article->setCategoryId($row['category_id']);
        $article->setStatus($row['status']);
        $article->setCategoryTitle($row['category']);
        $article->setUserPseudo($row['pseudo']);
        if($row['status'] === null) {
            $article->setStatusName('En attente');
        } elseif($row['status'] == 0) {
            $article->setStatusName('Inactif');
        } elseif($row['status'] == 1) {
            $article->setStatusName('Actif');
        }
        return $article;
    }
    
    /**
     * Get article by id
     *
     * @param  int $id
     * @return Article $article
     */
    public function getArticle($id)
    {
        $sql = 'SELECT a.*, u.pseudo AS pseudo, c.title AS category
        FROM article a 
        INNER JOIN user u ON u.id = a.user_id 
        INNER JOIN category c ON c.id = a.category_id 
        WHERE a.id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $article = $this->buildObject($row);
        $result->closeCursor();
        return $article;
    }
    
    /**
     * Get all articles
     *
     * @return array [objects]
     */
    public function getArticles() {
        $sql = 'SELECT a.*, u.pseudo AS pseudo, c.title AS category
        FROM article a 
        INNER JOIN user u ON u.id = a.user_id 
        INNER JOIN category c ON c.id = a.category_id 
        WHERE a.user_id = u.id AND a.user_id = u.id
        ORDER BY id DESC';
        $result = $this->checkConnection()->query($sql);
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articles[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }
    
    /**
     * Get last articles
     *
     * @param  int $nbArticles
     * @param  int $status
     * @return array [objects]
     */
    public function getLastArticles($nbArticles, $status)
    {
        $sql = 'SELECT a.*, u.pseudo AS pseudo, c.title AS category 
        FROM article a 
        INNER JOIN user u ON u.id = a.user_id 
        INNER JOIN category c ON c.id = a.category_id 
        WHERE a.status = :status 
        ORDER BY a.id DESC LIMIT :nbArticles';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':nbArticles', $nbArticles, PDO::PARAM_INT);
        $result->bindValue(':status', $status, PDO::PARAM_INT);
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articles[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    /**
     * Add article
     *
     * @param  Parameter $post
     * @return int (ctaegory_id)
     */
    public function addArticle(Parameter $post, $date)
    {
        $sql = "INSERT INTO `article` (title, sentence, content, `filename`, `user_id`, created_at, published_at, updated_at, updated_user_id, category_id, `status`) 
                VALUES (:title, :sentence, :content, :filename, :user_id, :created_at, :published_at, :updated_at, :updated_user_id, :category_id, :status)";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':filename', 'tmp', PDO::PARAM_STR);
        $result->bindValue(':user_id', $post->get('userId'), PDO::PARAM_INT);
        $result->bindValue(':created_at', $date, PDO::PARAM_STR);
        $result->bindValue(':published_at', NULL, PDO::PARAM_STR);
        $result->bindValue(':updated_at', NULL, PDO::PARAM_STR);
        $result->bindValue(':updated_user_id', NULL, PDO::PARAM_INT);
        $result->bindValue(':category_id', $post->get('categoryId'), PDO::PARAM_INT);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->execute();
        $id = $this->checkConnection()->lastInsertId();
        $result->closeCursor();
        return $id;
    }

    /**
     * Update article
     *
     * @param  Parameter $post
     * @return bool (true if updated, false if category_id is wrong)
     */
    public function updateArticle(Parameter $post)
    {
        if(!$this->checkArticle($post->get('id'))) {
            return false;
        }
        $sql = "UPDATE article 
                SET title = :title, 
                sentence = :sentence, 
                content = :content,
                `filename` = :filename, 
                published_at = :published_at,
                updated_at = :updated_at,
                updated_user_id = :updated_user_id,
                category_id = :category_id,
                `status` = :status  
                WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':filename', $post->get('filename'), PDO::PARAM_STR);
        $result->bindValue(':published_at', $post->get('publishedAt'), PDO::PARAM_STR);
        $result->bindValue(':updated_at', $post->get('updatedAt'), PDO::PARAM_STR);
        $result->bindValue(':updated_user_id', $post->get('updatedUserId'), PDO::PARAM_INT);
        $result->bindValue(':category_id', $post->get('categoryId'), PDO::PARAM_INT);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }
    
    /**
     * Know if article exists
     *
     * @param  int $id
     * @return bool (true if article exists)
     */
    public function existsArticle($id)
    {
        $sql = 'SELECT title FROM article WHERE id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $exists = $result->fetch();
        $result->closeCursor();
        return ($exists) ? true : false;
    }

    /**
     * Check article id
     *
     * @param  int $id
     * @return bool (true if article id exists)
     */
    public function checkArticle($id)
    {
        $sql = "SELECT COUNT(*) FROM article WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return ($count > 0)? true : false;
    }
    
}
