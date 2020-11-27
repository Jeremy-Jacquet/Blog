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
     * Get homepage
     *
     * @return mixed $view
     */
    public function home()
    {
        $articles = $this->articleDAO->getLastArticles(NB_LAST_ARTICLES, ACTIVE_ARTICLE);
        $categories = Search::lookForOr($this->categoryDAO->getCategories(), [
            'status' => MAIN_CATEGORY
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
            'status' => MAIN_CATEGORY
            ]);
        $categoriesActive = Search::lookForOr($this->categoryDAO->getCategories(), [
            'status' => ACTIVE_CATEGORY
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
            'status' => ACTIVE_ARTICLE
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
        } else {
            $articles = Search::lookForOr($this->articleDAO->getArticles(), [
                'categoryId' => $id
            ]);
            $category = $this->categoryDAO->getCategory($id);
            return $this->view->render($this->controller, 'articlesByCategory', [
            'articles' => $articles,
            'category' => $category
            ]);
        }    
    }
    
    /**
     * Get single article page
     *
     * @param  int $id
     * @return mixed $view
     */
    public function single($id)
    {
        $article = Search::lookForOr($this->articleDAO->getArticles(), [
            'id' => $id
        ]);
        if(empty($article)) {
            $this->alert->addError("L'article recherché n'existe pas.");
            header("Location: ".URL."articles");
            exit;
        } else {
            return $this->view->render($this->controller, 'single', [
                'article' => $article[0],
                'comment' => ($this->session->get('comment'))? $this->session->show('comment') : ''
            ]);
        }
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
            } else {
                $this->alert->addError("Il y a eu un problème avec votre inscription.");
            }
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
        } else {
            $this->userDAO->updateUser($user[0]->getId(), 'role_id', MEMBER_ROLE);
            $this->userDAO->updateUser($user[0]->getId(), 'token', NULL);
            $this->alert->addSuccess("Félicitations, vous êtes bien inscrit.");            
            header("Location: ".URL."accueil");
            exit;
        }       
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
        if($post->get('submit')) {
            if($this->validation->validateInput('user', $post)) {
                $user = Search::lookForOr($this->userDAO->getUsers(), [
                    'pseudo' => $post->get('pseudo')
                ]);
                if(!$user) {
                    $this->alert->addError("Vos identifiants sont incorrects.");
                } else {
                    if($user[0]->getLevel() < MEMBER_LEVEL) {
                        $this->alert->addError("Vous devez d'abord valider votre compte.");
                    } else {
                        if(!password_verify($post->get('password'), $user[0]->getPassword())) {
                            $this->alert->addError("Vos identifiants sont incorrects.");
                        } else {          
                            $this->userDAO->updateUser($user[0]->getId(), 'last_connection', $this->date);
                            $this->alert->addSuccess("Content de vous revoir.");
                            $this->session->set('id', $user[0]->getId());
                            $this->session->set('level', $user[0]->getLevel());
                            $this->session->set('pseudo', $user[0]->getPseudo());
                            ($this->checkAdmin())? header("Location: ".URL."admin") : header("Location: ".URL."profil");
                            exit;
                        }
                    }
                }
            }
        }
        return $this->view->render($this->controller, 'login', [
            'post'=> $post
        ]);
    }
}
