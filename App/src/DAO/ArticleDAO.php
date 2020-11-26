<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Article;
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
    
}
