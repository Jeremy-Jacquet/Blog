<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\entity\Category;
use App\src\blogFram\Parameter;
use \PDO;

/**
 * CategoryDAO
 */
class CategoryDAO extends DAO
{    
    /**
     * Hydrate category object
     *
     * @param  mixed $row
     * @return Category $category
     */
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
    
    /**
     * Get category by id
     *
     * @param  int $id
     * @return Category $category
     */
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
    
    /**
     * Get all categories
     *
     * @return array [Objects]
     */
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
    
    /**
     * Add category
     *
     * @param  Parameter $post
     * @return int (ctaegory_id)
     */
    public function addCategory(Parameter $post)
    {
        var_dump($post);
        $sql = "INSERT INTO `category` (title, sentence, `filename`, `status`) 
                VALUES (:title, :sentence, :filename, :status)";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
        $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
        $result->bindValue(':filename', $post->get('filename'), PDO::PARAM_STR);
        $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
        $result->execute();
        $id = $this->checkConnection()->lastInsertId();
        $result->closeCursor();
        return $id;
    }
    
    /**
     * Update category
     *
     * @param  Parameter $post
     * @return bool (true if updated, false if category_id is wrong)
     */
    public function updateCategory(Parameter $post)
    {
        $sql = "SELECT COUNT(*) FROM category WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch(PDO::FETCH_ASSOC);
        if($count > 0) {
            $sql = "UPDATE category SET title = :title, sentence = :sentence, `filename` = :filename, `status` = :status  WHERE id = :id";
            $result = $this->checkConnection()->prepare($sql);
            $result->bindValue(':title', $post->get('title'), PDO::PARAM_STR);
            $result->bindValue(':sentence', $post->get('sentence'), PDO::PARAM_STR);
            $result->bindValue(':filename', $post->get('filename'), PDO::PARAM_STR);
            $result->bindValue(':status', $post->get('status'), PDO::PARAM_INT);
            $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
            $result->execute();
            $result->closeCursor(); 
            return true;
        }
        $result->closeCursor(); 
        return false;
    }
    
    /**
     * Know if category exists
     *
     * @param  int $id
     * @return bool (true if category exists)
     */
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
