<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Category;
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
        return $category;
    }

    public function getCategory($id)
    {
        $sql = 'SELECT * FROM category WHERE id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $category = $this->buildObject($row);
        $result->closeCursor();
        return $category;
    }

    public function getCategories()
    {
        $sql = 'SELECT * FROM category ORDER BY id DESC';
        $result = $this->checkConnection()->query($sql);
        $result->execute();
        $categories = [];
        foreach ($result as $row){
            $categoryId = $row['id'];
            $categories[$categoryId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $categories;
    }

    public function existsCategory($id)
    {
        $sql = 'SELECT title FROM category WHERE id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $exists = $result->fetch();
        $result->closeCursor();
        return ($exists) ? true : false;
    }

}
