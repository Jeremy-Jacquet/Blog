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

    public function getCategories($highlight = null)
    {
        if($highlight) {
            $sql = 'SELECT * FROM category WHERE status = 1';
        }
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

}
