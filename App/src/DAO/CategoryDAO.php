<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Category;
use App\src\blogFram\Parameter;
use \PDO;

class CategoryDAO extends DAO
{    

    private function buildObject($row)
    {
        $category = new Category();
        $category->setId($row['id']);
        $category->setTitle($row['title']);
        $category->setSentence($row['sentence']);
        $category->setFilename($row['filename']);
        $category->setStatus($row['status']);
        if($row['status'] == 0) {
            $category->setStatusName('inactive');
        } elseif($row['status'] == 1) {
            $category->setStatusName('active');
        }
        return $category;
    }

    public function getOneCategory($categoryId)
    {
        if(!$this->checkCategoryId($categoryId)) {
            return false;
        }
        $sql = 'SELECT * FROM category WHERE id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $category = $this->buildObject($row);
        $result->closeCursor();
        return $category;
    }

    public function getCategories($attributes, $limit = null, $start = null)
    {
        $sql = "SELECT * FROM category c ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('category', $attributes);
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
        $categories = [];
        foreach ($result as $row){
            $categories[$row['id']] = $this->buildObject($row);
        }
        $result->closeCursor();
        return ($categories)? $categories : false;
    }

    public function addCategory($post)
    {
        $this->checkConnection()->beginTransaction();
        $sql = "INSERT INTO `category` (title, sentence, `filename`, `status`) 
                VALUES (:title, :sentence, :filename, :status)";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
        $result->bindValue(':filename', 'tmp.'.$post->get('extension'), PDO::PARAM_STR);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->execute();
        $newCategoryId = $this->checkConnection()->lastInsertId();
        $sql = "UPDATE `category` SET `filename` = :filename WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $newCategoryId, PDO::PARAM_INT);
        $result->bindValue(':filename', $newCategoryId.'.'.$post->get('extension'), PDO::PARAM_STR);
        $result->execute();
        $this->checkConnection()->commit();
        $result->closeCursor();
        return $newCategoryId;
    }

    public function updateCategory($post)
    {
        if(!$this->checkCategoryId($post->get('id'))) {
            return false;
        }
        $sql = "UPDATE `category` SET title = :title, sentence = :sentence, `status` = :status  WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function deleteCategory($post)
    {
        if(!$this->checkCategoryId($post->get('id'))) {
            return false;
        }
        $sql = "DELETE FROM `category` WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function checkCategoryId($categoryId)
    {
        $sql = "SELECT COUNT(*) FROM `category` WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $categoryId, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch();
        $result->closeCursor();
        return ($count[0] > 0)? true : false;
    }

    /**
     * count categories
     *
     * @param  array $attributes 
     * @return int
     */
    public function countCategories($attributes)
    {
        $sql = "SELECT COUNT(*) FROM category c ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('category', $attributes);
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
