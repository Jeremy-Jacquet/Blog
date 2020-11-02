<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Article;

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
        $article->setUserId($row['user_id']);
        $article->setCreatedAt($row['created_at']);
        $article->setPublishedAt($row['published_at']);
        $article->setUpdatedAt($row['updated_at']);
        $article->setUpdatedUserId($row['updated_user_id']);
        $article->setCategoryId($row['category_id']);
        $article->setStatus($row['status']);
        $article->setUserPseudo($row['pseudo']);
        $article->setCategoryTitle($row['title']);
        return $article;
    }

    public function getLastArticles($numberArticles)
    {
        $sql = 'SELECT a.id, a.title, a.sentence, a.content, a.filename, a.user_id, a.created_at, a.published_at, a.updated_at, a.updated_user_id, a.category_id, a.status, u.pseudo, c.title
            FROM article a 
            INNER JOIN user u ON u.id = a.user_id 
            INNER JOIN category c ON c.id = a.category_id 
            WHERE a.status = 1 
            ORDER BY id 
            DESC LIMIT :nb';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':nb', $numberArticles, \PDO::PARAM_INT);
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articleId = $row['id'];
            $articles[$articleId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function getArticles($status)
    {
        $sql = 'SELECT a.id, a.title, a.sentence, a.content, a.filename, a.user_id, a.created_at, a.published_at, a.updated_at, a.updated_user_id, a.category_id, a.status, u.pseudo, c.title
            FROM article a 
            INNER JOIN user u ON u.id = a.user_id 
            INNER JOIN category c ON c.id = a.category_id';
        if($status != null) {
            $sql = $sql.' WHERE a.status = :status ORDER BY a.id DESC';
            $result = $this->checkConnection()->prepare($sql);
            $result->bindValue(':status', $status, \PDO::PARAM_INT);
        } else {
            $sql = $sql.' WHERE a.status IS NULL ORDER BY a.id DESC';
            $result = $this->checkConnection()->query($sql);
        }
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articleId = $row['id'];
            $articles[$articleId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function getArticlesByCategory($categoryId)
    {
        $sql = 'SELECT a.id, a.title, a.sentence, a.content, a.filename, a.user_id, a.created_at, a.published_at, a.updated_at, a.updated_user_id, a.category_id, a.status, u.pseudo, c.title
            FROM article a 
            INNER JOIN user u ON u.id = a.user_id 
            INNER JOIN category c ON c.id = a.category_id 
            WHERE a.status = 1 
            AND a.category_id = :category_id ORDER BY a.id DESC';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articleId = $row['id'];
            $articles[$articleId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

}
