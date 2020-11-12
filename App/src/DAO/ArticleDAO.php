<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Article;
use \PDO;

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
        return $article;
    }

    public function getArticle($id)
    {
        $sql = 'SELECT * FROM article WHERE id = :id';
        $result = $this->checkConnexion()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $article = $this->buildObject($row);
        $result->closeCursor();
        return $article;
    }

    public function getArticles() {
        $sql = 'SELECT * FROM article ORDER BY id DESC';
        $result = $this->checkConnexion()->query($sql);
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articles[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function getArticlesBy($condition = null, $value = null) {
        $sql = 'SELECT * FROM article';
        if(is_null($value)) {
            if(is_null($condition)) {
                $sql .= ' ORDER BY id DESC';
            } elseif($condition === 'status') {
                $sql .= ' WHERE status IS NULL ORDER BY id DESC';
            }
            $result = $this->checkConnexion()->query($sql);
        } else {
            if($condition === 'category' AND !empty($value)) {
                $sql .= ' WHERE category_id = :value ORDER BY id DESC';
            } elseif($condition === 'status' AND !empty($value)) {
                $sql .= ' WHERE status = :value ORDER BY id DESC';
            } elseif($condition === 'lasts' AND !empty($value)) {
                $sql .= ' ORDER BY id DESC LIMIT :value';
            }
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':value', $value, PDO::PARAM_INT);
        }
        $result->execute();
        $articles = [];
        foreach ($result as $row){
            $articles[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $articles;
    }

    public function existsArticle($id)
    {
        $sql = 'SELECT title FROM article WHERE id = :id';
        $result = $this->checkConnexion()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $exists = $result->fetch();
        $result->closeCursor();
        return ($exists) ? true : false;
    }
    
}
