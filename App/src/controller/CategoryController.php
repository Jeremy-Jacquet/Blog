<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Alert;
use App\src\blogFram\Image;
use App\src\constraint\Validation;
use App\src\DAO\CategoryDAO;

class CategoryController
{
    private $alert;
    private $validation;
    private $categoryDAO;

    public function __construct($alert, $validation)
    {
        $this->alert = $alert;
        $this->validation = $validation;
        $this->categoryDAO = new CategoryDAO;
    }

    public function addCategory($post)
    {
        $newCategoryId = $this->categoryDAO->addCategory($post);
        return $newCategoryId;
    }

    public function updateCategory($post)
    {
        $isSuccess = $this->categoryDAO->updateCategory($post);
        return $isSuccess;
    }

    public function deleteCategory($post)
    {
        $isSuccess = $this->categoryDAO->deleteCategory($post);
        return $isSuccess;
    }
    
    public function getOneCategory($categoryId)
    {
        $category = $this->categoryDAO->getOneCategory($categoryId);
        return $category;
    }

    public function getCategories($attributes, $limit = null, $start = null)
    {
        $categories = $this->categoryDAO->getCategories($attributes, $limit, $start);
        return $categories;
    }

    public function countCategories($attributes)
    {
        return $this->categoryDAO->countCategories($attributes);
    }
}
