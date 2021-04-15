<?php

namespace App\src\controller;

use App\src\controller\ArticleController;
use App\src\controller\UserController;
use App\src\controller\CommentController;
use App\src\controller\CategoryController;

class MainController
{
    private $articleController;
    private $userController;
    private $commentController;
    private $categoryController;

    public function __construct($session, $alert, $validation)
    {
        $this->articleController = new ArticleController($alert, $validation);
        $this->userController = new UserController($session, $alert, $validation);
        $this->commentController = new CommentController($alert, $validation);
        $this->categoryController = new CategoryController($alert, $validation);
    }

    public function add($entity, $post)
    {
        if($entity === 'article') {  
            $newEntityId = $this->articleController->addArticle($post);
        } elseif($entity === 'user') {
            $newEntityId = $this->userController->addUser($post);
        } elseif($entity === 'comment') {
            $newEntityId = $this->commentController->addComment($post);
        } elseif($entity === 'category') {
            $newEntityId = $this->categoryController->addCategory($post);
        }
        return $newEntityId;
    }

    public function update($entity, $post)
    {
        if($entity === 'article') {  
            $isSuccess = $this->articleController->updateArticle($post);
        } elseif($entity === 'user') {
            $isSuccess = $this->userController->updateUser($post);
        } elseif($entity === 'account') {
            $isSuccess = $this->userController->updateUserAccount($post);
        } elseif($entity === 'comment') {
            $isSuccess = $this->commentController->updateComment($post);
        } elseif($entity === 'category') {
            $isSuccess = $this->categoryController->updateCategory($post);
        }
        return $isSuccess;
    }

    public function delete($entity, $post)
    {
        if($entity === 'article') {  
            $isSuccess = $this->articleController->deleteArticle($post);
        } elseif($entity === 'user') {
            $isSuccess = $this->userController->deleteUser($post);
        } elseif($entity === 'comment') {
            $isSuccess = $this->commentController->deleteComment($post);
        } elseif($entity === 'category') {
            $isSuccess = $this->categoryController->deleteCategory($post);
        }
        return $isSuccess;
    }

    public function getOne($entity, $entityId)
    {
        if($entity === 'article') {
            $result = $this->articleController->getOneArticle($entityId);
        } elseif($entity === 'user') {
            $result = $this->userController->getOneUser($entityId);
        } elseif($entity === 'category') {
            $result = $this->categoryController->getOneCategory($entityId);
        }
        return $result;
    }

    public function get($entities, $attributes, $limit = null, $start = null)
    {
        if($entities === 'articles') {
            $result = $this->articleController->getArticles($attributes, $limit, $start);
        } elseif($entities === 'users') {
            $result = $this->userController->getUsers($attributes, $limit, $start);
        } elseif($entities === 'categories') {
            $result = $this->categoryController->getCategories($attributes, $limit, $start);
        } elseif($entities === 'comments') {
            $result = $this->commentController->getComments($attributes, $limit, $start);
        }
        return $result;
    }

    public function getLastArticles($numberOfArticles)
    {
        $lastArticles = $this->articleController->getLastArticles($numberOfArticles);
        return $lastArticles;
    }
          
    /**
     * count entities
     *
     * @param  string $entities
     * @param  array $entityAttributes
     * @return void
     */
    public function count($entities, $entityAttributes)
    {
        if($entities === 'articles') {
            $count = $this->articleController->countArticles($entityAttributes);
        } elseif($entities === 'users') { 
            $count = $this->userController->countUsers($entityAttributes); 
        } elseif($entities === 'categories') { 
            $count = $this->categoryController->countCategories($entityAttributes); 
        } elseif($entities === 'comments') { 
            $count = $this->commentController->countComments($entityAttributes); 
        }
        return $count;
    }

}
