<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Category;

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

    public function getCategories($status)
    {
        if($status == null) {
            $sql = 'SELECT * FROM category WHERE status IS NULL';
            $result = $this->checkConnection()->query($sql);
        } else{
            $sql = 'SELECT * FROM category WHERE status = :status';
            $result = $this->checkConnection()->prepare($sql);
            $result->bindValue(':status', $status, \PDO::PARAM_INT);
        }
        $result->execute();
        $categories = [];
        foreach ($result as $row){
            $categoryId = $row['id'];
            $categories[$categoryId] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $categories;
    }

    public function getCategory($id)
    {
        $sql = 'SELECT * FROM category WHERE (status = 1 OR status IS NULL) AND id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $id, \PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $category = $this->buildObject($row);
        $result->closeCursor();
        return $category;
    }

}
