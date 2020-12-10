<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Search;

/**
 * BackController
 */
class BackController extends Controller
{    
    /**
     * @var ArticleController
     */
    protected $articleController;

    /**
     * @var CategoryController
     */
    protected $categoryController;

    /**
     * @var CommentController
     */
    protected $commentController;

    /**
     * @var UserController
     */
    protected $userController;

    /**
     * @var string
     */
    private $controller = 'back';
    
    /**
     * Construct BackController
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();  
        $this->articleController = new ArticleController;
        $this->categoryController = new CategoryController;
        $this->commentController = new CommentController;
        $this->userController = new UserController;
        $this->logController = new LogController;
    }
    
    /**
     * Get profile page
     *
     * @param  Parameter $post
     * @return mixed $view
     */
    public function profile(Parameter $post)
    {
        if(!$this->checkLoggedIn()) {
            $this->alert->addError("Vous devez être connecté pour accéder à cette section.");
            header("Location: ".URL."connexion");
            exit;
        }
        if($post->get('submit')) {
            echo 'coucou';
            $this->userController->updateAccount($post);
        }
        return $this->view->render($this->controller, 'profile', [
            'user' => $this->userDAO->getUser($this->session->get('id'))
        ]); 
    }
    
    /**
     * Get admin dashboard page
     *
     * @return mixed $view
     */
    public function dashboard(Parameter $post)
    {
        if(!$this->checkAdmin()) {
            $this->alert->addError("Vous n'avez pas le droit d'accéder à cette page.");
            header("Location: ".URL."accueil");
            exit;
        }
        if($post->get('submit')) {
            if($post->get('entity') === 'comment') {
                $this->commentController->moderateComment($post);
            } else {
                $this->alert->addError("L'entité ".$post->get('entity')." n'est pas reconnue.");
            }
        }
        $pendingArticles = Search::lookForOr($this->articleDAO->getArticles(),[
            'status' => parent::PENDING_ARTICLE
        ]);
        $pendingComments = Search::lookForOr($this->commentDAO->getComments(),[
            'status' => parent::PENDING_COMMENT
        ]);
        return $this->view->render($this->controller, 'dashboard', [
            'users' => $this->userDAO->getUsers(),
            'pendingArticles' => $pendingArticles,
            'pendingComments' => $pendingComments
        ]);
    }
    
    /**
     * Display users for administration
     *
     * @param  Parameter $post
     * @return void|mixed $view
     */
    public function displayUsers(Parameter $post)
    {
        if(!$this->checkAdmin()) {
            $this->alert->addError("Vous n'avez pas le droit d'accéder à cette page.");
            header("Location: ".URL."accueil");
            exit;
        }
        if(!$post->get('submit') OR $post->get('delete')) {
            if($post->get('delete')) {
                $this->userController->deleteUser($post);
            }
            return $this->view->render($this->controller, 'users', [
                'users' => $this->userDAO->getUsers()
            ]);
        }
        if($post->get('update')) {
            $this->userController->updateUser($post);
        }
        $user = $this->userDAO->getUser($post->get('id'));
        return $this->view->render($this->controller, 'user', [
            'user' => $user
        ]);
    }
    
    /**
     * Display categories for administration
     *
     * @return void
     */
    public function displayCategories()
    {
        if(!$this->checkAdmin()) {
            $this->alert->addError("Vous n'avez pas le droit d'accéder à cette page.");
            header("Location: ".URL."accueil");
            exit;
        }
        $categories = $this->categoryDAO->getCategories();
        $this->view->render($this->controller, 'categories/display-categories', [
            'categories' => $categories
        ]);
    }
    
    /**
     * Category administration
     *
     * @param  Parameter $get
     * @param  Parameter $post
     * @return void
     */
    public function adminCategory(Parameter $get, Parameter $post)
    {
        if($get->get('action') === 'ajouter') {
            if($post->get('submit')) {
                $id = $this->categoryController->addCategory($post);
                if($id) {
                    header("Location: ".URL."categories&id=".$id);
                    exit;
                }
            }
            $this->view->render($this->controller, 'categories/add-category');
        }
        
    }

}
