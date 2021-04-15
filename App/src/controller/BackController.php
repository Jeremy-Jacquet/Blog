<?php

namespace App\src\controller;

use App\src\blogFram\Controller;
use App\src\entity\Article;
use App\src\entity\Comment;

class BackController extends Controller
{    
    public function __construct($get, $post, $file)
    {
        parent::__construct($get, $post, $file);
    }
    
    /**
     * display profile page
     *
     * @return mixed|void
     */
    public function goToProfile()
    {
        if(!$this->logController->checkIfIsLoggedIn(false, 'error', "Vous devez être connecté pour accéder à cette section.")) {
            $this->displayer->displayLocation('connexion');
        }
        if($this->post->get('submit')) {
            $this->mainController->update('account', $this->post, $this->file);
        }
        $user = $this->mainController->getOne('user', $this->session->get('id'));
        return $this->displayer->displayProfile($user);
    }
    
    /**
     * display dashboard
     *
     * @return mixed|void
     */
    public function goToDashboard()
    {
        //debut - a retirer

        $_SESSION['level'] = 100;
        $_SESSION['pseudo'] = 'admin';


        //fin
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            if($this->post->get('entity') === 'comment') {
                $this->mainController->update('comment', $this->post);
            }
        }
        $articlesAttributes = [['name' => 'status', 'value' => Article::STATUS['pending'], 'parameter' => 'integer']];
        $commentsAttributes = [['name' => 'status', 'value' => Comment::STATUS['pending'], 'parameter' => 'integer']];
        $pendingArticles = $this->mainController->get('articles', $articlesAttributes);
        $pendingComments = $this->mainController->get('comments', $commentsAttributes);
        $users[$this->session->get('id')] = $this->mainController->getOne('user', $this->session->get('id'));
        if($pendingComments) {
            foreach($pendingComments as $comment) {
                $users[$comment->getUserId()] = $this->mainController->getOne('user', $comment->getUserId());
            }
        }
        return $this->displayer->displayDashboard($users, $pendingArticles, $pendingComments);
    }
    
    /**
     * display users for administration
     *
     * @return mixed|void
     */
    public function goToDisplayUsers()
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            $user = $this->mainController->getOne('user', $this->post->get('id'));
            return $this->displayer->displayUserAdmin($user);
        }
        $users = $this->mainController->get('users', 'all');
        return $this->displayer->displayUsersAdmin($users);
    }
    
    /**
     * go to update user by admin
     *
     * @return void
     */
    public function goToUpdateUserByAdmin() 
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('update')) {
            $this->mainController->update('user', $this->post);
        }
    }
    
    /**
     * go to delete user by admin
     *
     * @return void
     */
    public function  goToDeleteUserByAdmin() 
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('delete')) {
            $this->mainController->delete('user', $this->post);
        }
    }

    /**
     * display categories for administration
     *
     * @return mixed|void
     */
    public function  goToDisplayCategories()
    {
        $this->logController->checkLevel('admin');
        $categories = $this->mainController->get('categories', 'all');
        return $this->displayer->displayCategoriesAdmin($categories);
    }
    
    /**
     * go to add category
     *
     * @return mixed|void
     */
    public function  goToAddCategory()
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            $newCategoryId = $this->mainController->add('category');
            if($newCategoryId) {
                $this->displayer->displayLocation('categories&id='.$newCategoryId);
            }
        }
        return $this->displayer->displayAddCategory();
    }
    
    /**
     * update category
     *
     * @return mixed|void
     */
    public function  goToUpdateCategory()
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            if($this->mainController->update('category', $this->post)) {
                $this->displayer->displayLocation('articles&categorie='.$this->post->get('id'));
            }
        }
        $category = $this->mainController->getOne('category', $this->get->get('id'));
        return $this->displayer->displayUpdateCategory($category);
    }
    
    /**
     * go to delete category
     *
     * @return void
     */
    public function  goToDeleteCategory()
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('delete')) {
            if($this->mainController->delete('category', $this->post)) {
                $this->displayer->displayLocation('admin');
            }
        }
    }

    /**
     * display articles for administration
     *
     * @return mixed|void
     */
    public function  goToDisplayArticles()
    {
        $this->logController->checkLevel('admin');
        $articles = $this->mainController->get('articles', 'all');
        return $this->displayer->displayArticlesAdmin($articles);
    }
    
    /**
     * go to add article
     *
     * @return mixed|void
     */
    public function  goToAddArticle() 
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            $newArticleId = $this->mainController->add('article');
            if($newArticleId) {
                $this->displayer->displayLocation('articles&id='.$newArticleId);
            }
        }
        $categories = $this->mainController->get('categories', 'all');
        return $this->displayer->displayAddArticle($categories);
    }
    
    /**
     * go to update article
     *
     * @return mixed|void
     */
    public function  goToUpdateArticle() 
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            $this->mainController->update('article', $this->post);
        }
        $article = $this->mainController->getOne('article', $this->get->get('id'));
        $categories = $this->mainController->get('categories', 'all');
        return $this->displayer->displayUpdateArticle($article, $categories);
    }
    
    /**
     * go to delete article
     *
     * @return void
     */
    public function  goToDeleteArticle() 
    { 
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            $this->mainController->delete('article', $this->post);
        }
        $this->displayer->displayLocation(URL.'admin&categorie=articles');
    }

    /**
     * display comments for administration
     *
     * @return mixed|void
     */
    public function  goToDisplayComments()
    {
        $this->logController->checkLevel('admin');
        $commentsAttributes = [['name' => 'status', 'value' => Comment::STATUS['pending'], 'parameter' => 'integer']];
        $comments = $this->mainController->get('comments', $commentsAttributes);
        $users = [];
        if($comments) {
            foreach($comments as $comment) {
                $users[$comment->getUserId()] = $this->mainController->getOne('user', $comment->getUserId());
            }
        }
        return $this->displayer->displayCommentsAdmin($comments, $users);
    }

    public function goToAddComment()
    {
        $this->logController->checkLevel('member');
        $this->post->set('created_at', $this->date);
        $this->mainController->add('comment', $this->post);
    }

    /**
     * go to update comment
     *
     * @return void
     */
    public function  goToUpdateComment() 
    {
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            $this->mainController->update('comment', $this->post);
        }
        $this->displayer->displayLocation(URL.'admin&categorie=commentaires');
    }
    
    /**
     * go to delete comment
     *
     * @return void
     */
    public function  goToDeleteComment() 
    { 
        $this->logController->checkLevel('admin');
        if($this->post->get('submit')) {
            $this->mainController->delete('comment', $this->post);
        }
        $this->displayer->displayLocation(URL.'admin&categorie=commentaires');
    }

}
