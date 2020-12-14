<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Search;

/**
 * FrontController
 */
class FrontController extends Controller
{
    
    /**
     * @var string
     */
    private $controller = 'front';

    /**
     * Construct FrontController
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
     * Get login page / Login user
     *
     * @param  object $post
     * @return void|mixed $view
     */
    public function login(Parameter $post)
    {
        if($this->checkLoggedIn()) {
            $this->alert->addError("Vous êtes déjà connecté.");
            ($this->checkAdmin())? header("Location: ".URL."admin") : header("Location: ".URL."profil");
            exit;
        }
        $this->logController->login($post);
        return $this->view->render($this->controller, 'login', [
            'post'=> $post
        ]);
    }
    
    /**
     * Get homepage
     *
     * @return mixed $view
     */
    public function home()
    {
        $articles = $this->articleDAO->getLastArticles(parent::NB_LAST_ARTICLES, parent::ACTIVE_ARTICLE);
        $categories = Search::lookForOr($this->categoryDAO->getCategories(), [
            'status' => parent::MAIN_CATEGORY
        ]);
        return $this->view->render($this->controller, 'home', [
           'articles' => $articles,
           'categories' => $categories
        ]);
    }
    
    /**
     * Get categories page
     *
     * @return mixed $view
     */
    public function categories()
    {
        $categoriesMain = Search::lookForOr($this->categoryDAO->getCategories(), [
            'status' => parent::MAIN_CATEGORY
            ]);
        $categoriesActive = Search::lookForOr($this->categoryDAO->getCategories(), [
            'status' => parent::ACTIVE_CATEGORY
            ]);
        return $this->view->render($this->controller, 'categories', [
           'categoriesMain' => $categoriesMain,
           'categoriesActive' => $categoriesActive
        ]);
    }
    
    /**
     * Get articles page
     *
     * @return mixed $view
     */
    public function articles()
    {
        $articles = Search::lookForOr($this->articleDAO->getArticles(),[
            'status' => parent::ACTIVE_ARTICLE
        ]);
        return $this->view->render($this->controller, 'articles', [
           'articles' => $articles
        ]);
    }
    
    /**
     * Get articles page by category
     *
     * @param  int $id
     * @return mixed $view
     */
    public function articlesByCategory($id)
    {
        if(!$this->categoryDAO->existsCategory($id)) {
            $this->alert->addError("La catégorie recherchée n'existe pas.");
            header("Location: ".URL."articles");
            exit;
        }
        $articles = Search::lookForOr($this->articleDAO->getArticles(), [
            'categoryId' => $id
        ]);
        $category = $this->categoryDAO->getCategory($id);
        return $this->view->render($this->controller, 'articlesByCategory', [
        'articles' => $articles,
        'category' => $category
        ]);
    }
    
    /**
     * Get single article page
     *
     * @param  int $id
     * @return mixed $view
     */
    public function single($id, $post = null)
    {
        $article = Search::lookForOr($this->articleDAO->getArticles(), [
            'id' => $id
        ]);
        if(empty($article)) {
            $this->alert->addError("L'article recherché n'existe pas.");
            header("Location: ".URL."articles");
            exit;
        }
        if($post->get('submit')) {
            if($this->commentController->moderateComment($post)) {
                header("Location: ".URL."articles&id=$id");
                exit;
            }
        }
        $comments = Search::lookForAnd($this->commentDAO->getComments(), [
            'articleId' => $id,
            'status' => parent::ACTIVE_COMMENT
        ]); 
        $users = [];
        foreach($comments as $comment) {
            $users[$comment->getUserId()] = $this->userDAO->getUser($comment->getUserId());
        }
        return $this->view->render($this->controller, 'single', [
            'article' => $article[0],
            'users' => $users,
            'comments' => $comments,
            'content' => $post->get('content')? $post->get('content') : ''
        ]);
    }
    
    /**
     * Get register page
     *
     * @param  Parameter $post
     * @return mixed $view
     */
    public function displayRegister(Parameter $post = null)
    {
        if($this->checkLoggedIn()) {
            $this->alert->addError("Vous possédez déjà un compte.");
            header("Location: ".URL."profil");
            exit;
        } elseif($post->get('submit')) { 
            $validate = $this->validation->validateInput('user', $post);
            if($validate) {
                $this->register($post);
            }
        }
        return $this->view->render($this->controller, 'register', [
            'post' => $post
        ]); 
    }
    
    /**
     * Register user
     *
     * @param  Parameter $post
     * @return void|mixed $view
     */
    public function register(Parameter $post)
    {
        if(Search::lookForOr($this->userDAO->getUsers(), [
            'pseudo' => $post->get('pseudo'),
            'email' => $post->get('email')
            ])) {
            $this->alert->addError("Veuillez changer d'identifiants.");
        } else {
            $token = password_hash($this->date.$post->get('pseudo'), PASSWORD_BCRYPT);
            if($this->userDAO->addUser($post, $this->date, $token)) {
                $this->mailer->sendMail('register', $post, $token);
                $this->alert->addSuccess("Félicitations, un email de confirmation vous a été envoyé.");
                header("location: ".URL."accueil");
                exit;
            }
            $this->alert->addError("Il y a eu un problème avec votre inscription.");
        }
    }
    
    /**
     * Confirm user registration
     *
     * @param  string $email
     * @param  string $token
     * @return void
     */
    public function confirmRegister($email, $token)
    {
        $user = Search::lookForAnd($this->userDAO->getUsers(), [
            'email' => $email,
            'token' => $token
        ]);
        if(!$user) {
            $this->alert->addError("Votre inscription n'a pas aboutie. Veuillez vérifier que vous n'êtes pas déjà inscrit, ou veuillez vous réinscrire.");
            header("Location: ".URL."inscription");
            exit; 
        }
        $this->userDAO->updateUser($user[0]->getId(), 'role_id', parent::MEMBER_ROLE);
        $this->userDAO->updateUser($user[0]->getId(), 'token', NULL);
        $this->alert->addSuccess("Félicitations, vous êtes bien inscrit.");            
        header("Location: ".URL."accueil");
        exit;   
    }
    
}
