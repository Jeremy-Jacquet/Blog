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
    private function buildObject($row)
    {
        $article = new Article();
        $article->setId($row['id']);
        $article->setTitle($row['title']);
        $article->setSentence($row['sentence']);
        $article->setContent($row['content']);
        $article->setFilename($row['filename']);
        $article->setAuthorId($row['author_id']);
        $article->setCreatedAt($row['created_at']);
        $article->setUpdatedAt($row['updated_at']);
        $article->setAuthorIdWhoUpdated($row['author_id_who_updated']);
        $article->setCategoryId($row['category_id']);
        $article->setStatus($row['status']);
        $article->setCategoryTitle($row['category_title']);
        $article->setAuthorPseudo($row['pseudo']);
        if($row['status'] == 0) {
            $article->setStatusName('inactive');
        } elseif($row['status'] == 1) {
            $article->setStatusName('active');
        } elseif($row['status'] == 2) {
            $article->setStatusName('pending');
        }
        return $article;
    }

    public function getOneArticle($articleId)
    {
        if(!$this->checkArticleId($articleId)) {
            return false;
        }
        $sql = 'SELECT a.*, u.pseudo, c.title AS category_title
        FROM `article` a 
        INNER JOIN `user` u ON u.id = a.author_id 
        INNER JOIN `category` c ON c.id = a.category_id 
        WHERE a.id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $articleId, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $article = $this->buildObject($row);
        $result->closeCursor();
        return $article;
    }

    public function getArticles($attributes, $limit = null, $start = null ) 
    {
        $sql = "SELECT a.*, u.pseudo, c.title AS category_title
        FROM `article` a 
        INNER JOIN `user` u ON u.id = a.author_id 
        INNER JOIN `category` c ON c.id = a.category_id ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('article', $attributes);
        }
        $sql .= " ORDER BY a.id DESC";
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
        $articles = [];
        foreach ($result as $row){
            $articles[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return ($articles)? $articles : false;
    }

    public function getLastArticles($numberOfArticles)
    {
        $sql = 'SELECT a.*, u.pseudo, c.title AS category_title
        FROM `article` a 
        INNER JOIN `user` u ON u.id = a.author_id 
        INNER JOIN `category` c ON c.id = a.category_id 
        WHERE a.status = 1
        ORDER BY a.id DESC LIMIT :number_articles';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':number_articles', $numberOfArticles, PDO::PARAM_INT);
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articles[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function addArticle($post)
    {
        $this->checkConnection()->beginTransaction();
        $sql = "INSERT INTO `article` (title, sentence, content, `filename`, `author_id`, created_at, category_id, `status`) 
                VALUES (:title, :sentence, :content, :filename, :author_id, :created_at, :category_id, :status)";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':filename', 'tmp.'.$post->get('extension'), PDO::PARAM_STR);
        $result->bindValue(':author_id', $post->get('author_id'), PDO::PARAM_INT);
        $result->bindValue(':created_at', $post->get('created_at'), PDO::PARAM_STR);
        $result->bindValue(':category_id', $post->get('category_id'), PDO::PARAM_INT);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->execute();
        $newArticleId = $this->checkConnection()->lastInsertId();
        $sql = "UPDATE `article` SET `filename` = :filename WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $newArticleId, PDO::PARAM_INT);
        $result->bindValue(':filename', $newArticleId.'.'.$post->get('extension'), PDO::PARAM_STR);
        $result->execute();
        $this->checkConnection()->commit();
        $result->closeCursor();
        return $newArticleId;
    }

    public function updateArticle($post)
    {
        if(!$this->checkArticleId($post->get('id'))) {
            return false;
        }
        $sql = "UPDATE `article` SET title = :title, sentence = :sentence, content = :content, updated_at = :updated_at, author_id_who_updated = :author_id_who_updated, category_id = :category_id, `status` = :status WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
        $result->bindValue(':content', $post->get('content'), PDO::PARAM_STR);
        $result->bindValue(':updated_at', $post->get('updated_at'), PDO::PARAM_STR);
        $result->bindValue(':author_id_who_updated', $post->get('author_id_who_updated'), PDO::PARAM_INT);
        $result->bindValue(':category_id', $post->get('category_id'), PDO::PARAM_INT);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function deleteArticle($post)
    {
        if(!$this->checkArticleId($post->get('id'))) {
            return false;
        }
        $sql = "DELETE FROM `article` WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function checkArticleId($articleId)
    {
        $sql = "SELECT COUNT(*) FROM `article` WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $articleId, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch();
        $result->closeCursor();
        return ($count[0] > 0)? true : false;
    }

    /**
     * count articles
     *
     * @param  array $attributes
     * @return int
     */
    public function countArticles($attributes)
    {
        $sql = "SELECT COUNT(*) FROM article a ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('article', $attributes);
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
