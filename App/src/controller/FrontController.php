<?php

namespace App\src\controller;

use App\src\blogFram\Controller;
use App\src\blogFram\Pagination;
use App\src\blogFram\Parameter;
use App\src\entity\Article;
use App\src\entity\Category;
use App\src\entity\Comment;

class FrontController extends Controller
{
    public function __construct($get, $post, $file)
    {
        parent::__construct($get, $post, $file);
    }

    public function test()
    {
        return $this->displayer->displayTest();
    }

    /**
     * go to login page
     *
     * @return void|mixed
     */
    public function goToLoginForm()
    { 
        if($this->logController->checkIfIsLoggedIn(true, 'error', "Vous êtes déjà connecté")) {
            $location = ($this->logController->checkLevel('admin'))? 'admin' : 'profil';
            $this->displayer->displayLocation($location);
        }
        if($this->post->get('submit')) {
            $this->logController->login($this->post);
        }
        $this->displayer->displayLogin($this->post);
    }
    
    /**
     * go to logout
     *
     * @return void
     */
    public function goToLogout() 
    {
        $this->logController->logout();
    }
    
    /**
     * go to register page
     *
     * @return mixed|void
     */
    public function goToRegisterForm()
    {
        if($this->logController->checkIfIsLoggedIn(true, 'error', "Vous possédez déjà un compte.")) {
            $this->displayer->displayLocation('profil');
        } elseif($this->post->get('submit')) { 
            if($this->validation->checkInputValidity('user', $this->post)) {
                $this->logController->register($this->post, $this->date);
                $this->displayer->displayLocation('accueil');
            }
        }
        return $this->displayer->displayRegister($this->post);
    }
    
    /**
     * go to confirm register
     *
     * @return void
     */
    public function goToConfirmRegister() 
    {
        $this->logController->confirmRegister($this->get);
        $this->displayer->displayLocation('accueil');
    }

    /**
     * go to homepage
     *
     * @return mixed
     */
    public function goToHome()
    {
        $articlesAttributes = [['name' => 'status', 'value' => Article::STATUS['active'], 'parameter' => 'integer']];
        $categoriesAttributes = [['name' => 'status', 'value' => Category::STATUS['main'], 'parameter' => 'integer']];
        $articles = $this->mainController->get('articles', $articlesAttributes, 2, 0);
        $categories = $this->mainController->get('categories', $categoriesAttributes, 2, 0);
        if($this->post->get('contact')) {
            if($this->validation->checkInputValidity('contact', $this->post)) {
                $this->mailer->sendMail('contact', $this->post);
                $alertMessage = "Merci de nous avoir contacter, nous vous répondrons dans les plus brefs délais.";
                $this->alert->set('success', 'normal', 'main', $alertMessage);
            }
        }
        return $this->displayer->displayHome($articles, $categories);
    }

    /**
     * go to categories page
     *
     * @return mixed
     */
    public function goToCategories()
    {
        $mainAttribute = [['name' => 'status', 'value' => Category::STATUS['main'], 'parameter' => 'integer']];
        $activeAttribute = [['name' => 'status', 'value' => Category::STATUS['active'], 'parameter' => 'integer']];
        $mainCategories = $this->mainController->get('categories', $mainAttribute);
        $activeCategories = $this->mainController->get('categories', $activeAttribute);
        return $this->displayer->displayCategories($mainCategories, $activeCategories);
    }
    
    /**
     * go to articles page
     *
     * @return mixed
     */
    public function goToBlog()
    {
        $articlesAttributes = [['name' => 'status', 'value' => Article::STATUS['active'], 'parameter' => 'integer']];
        $articlesCount = $this->mainController->count('articles', $articlesAttributes);
        $pagination = new Pagination(6, $this->get->get('page'), $articlesCount);
        $articles = $this->mainController->get('articles', $articlesAttributes, $pagination->getLimit(), $pagination->getStart());
        return $this->displayer->displayBlog($articles, $pagination);
    }
    
    /**
     * go to articles page by category
     *
     * @return mixed|void
     */
    public function goToArticlesByCategory()
    {
        $category = $this->mainController->getOne('category', $this->get->get('id'));
        if(!$category) {
            $this->displayer->displayLocation('articles');
        }
        $articlesAttributes = [
            ['name' => 'status', 'value' => Article::STATUS['active'], 'parameter' => 'integer'],
            ['name' => 'category_id', 'value' => $this->get->get('id'), 'parameter' => 'integer']
        ];
        $articlesCount = $this->mainController->count('articles', $articlesAttributes);
        $pagination = new Pagination(6, $this->get->get('page'), $articlesCount);
        $articles = $this->mainController->get('articles', $articlesAttributes, $pagination->getLimit(), $pagination->getStart());
        return $this->displayer->displayArticlesByCategory($category, $articles, $pagination);
    }
    
    /**
     * go to single article page
     *
     * @return mixed|void
     */
    public function goToSingle()
    {
        $article = $this->mainController->getOne('article', $this->get->get('id'));
        if(!$article) {
            $this->displayer->displayLocation('articles');
        }
        if($this->post->get('submit')) {
            if($this->mainController->update('comment', $this->post)) {
                $this->displayer->displayLocation('articles&id='.$this->get->get('id'));
            }
        }
        $commentsAttributes = [
            ['name' => 'article_id', 'value' => $this->get->get('id'), 'parameter' => 'integer'],
            ['name' => 'status', 'value' => Comment::STATUS['active'], 'parameter' => 'integer']
        ];
        $comments = $this->mainController->get('comments', $commentsAttributes);
        $users = [];
        if($comments) {
            foreach($comments as $comment) {
                $users[$comment->getUserId()] = $this->mainController->getOne('user', $comment->getUserId());
            }
        }
        $content = ($this->post->get('content'))? $this->post->get('content') : '';
        return $this->displayer->displaySingle($article, $users, $comments, $content);
    }

}
