<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Mailer;
use App\src\blogFram\Search;
use \DateTime;

class FrontController extends Controller
{

    private $controller = 'front';
    private $mailer;

    public function home()
    {
        $articles = $this->articleDAO->getArticlesBy('lasts', NB_LAST_ARTICLES);
        $categories = Search::lookForOr($this->categoryDAO->getCategories(), [
            'status' => MAIN_CATEGORY
        ]);
        return $this->view->render($this->controller, 'home', [
           'articles' => $articles,
           'categories' => $categories
        ]);
    }

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

    public function articles()
    {
        $articles = Search::lookForOr($this->articleDAO->getArticles(),[
            'status' => ACTIVE_ARTICLE
        ]);
        return $this->view->render($this->controller, 'articles', [
           'articles' => $articles
        ]);
    }

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
                'article' => $article[0]
            ]);
        }
    }

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

    public function register(Parameter $post)
    {
        if(Search::lookForOr($this->userDAO->getUsers(), [
            'pseudo' => $post->get('pseudo'),
            'email' => $post->get('email')
            ])) {
            $this->alert->addError("Veuillez changer d'idetifiants.");
        } else {
            $objDateTime = new DateTime('NOW');
            $date = $objDateTime->format('Y-m-d H:i:s');
            $token = password_hash($date.$post->get('pseudo'), PASSWORD_BCRYPT);
            if($this->userDAO->addUser($post, $date, $token)) {
                $this->sendMail($post, $token);
                $this->alert->addSuccess("Félicitations, un email de confirmation vous a été envoyé.");
                header("location: ".URL."accueil");
                exit;
            } else {
                $this->alert->addError("Il y a eu un problème avec votre inscription.");
            }
        }
    }

    public function sendMail(Parameter $post, $token = null)
    {
        $title = 'Email de confirmation';
        $body = $this->view->renderFile('../App/template/mail/mail_confirmation.php', [
            'title' => $title,
            'post' => $post,
            'token' => $token
            ]);
        $this->mailer = new Mailer();
        $this->mailer->setMail($title, FROM_EMAIL, FROM_USERNAME, $post->get('email'), $body);
        $this->mailer->sendMail();        
    }

    public function confirmRegister($email, $token)
    {
        $user = Search::lookForAnd($this->userDAO->getUsers(), [
            'email' => $email,
            'token' => $token
        ]);
        if(!$user) {
            $this->alert->addError("Votre inscription n'a pas aboutie, veuillez vous réinscrire.");
            header("Location: ".URL."inscription");
            exit; 
        } else {
            $this->userDAO->updateUser($user[0]->getId(), 'role_id', ROLE_MEMBER);
            $this->userDAO->updateUser($user[0]->getId(), 'token', NULL);
            $this->alert->addSuccess("Félicitations, vous êtes bien inscrit.");            
            header("Location: ".URL."accueil");
            exit;
        }       
    }

    public function login(Parameter $post)
    {
        
        if($this->checkLoggedIn()) {
            $this->alert->addError("Vous êtes déjà connecté.");
            ($this->checkAdmin())? header("Location: ".URL."admin") : header("Location: ".URL."profil");
            exit;
        }
        if($post->get('submit')) {
            $user = Search::lookForANd($this->userDAO->getUsers(), [
                'pseudo' => $post->get('pseudo')
            ]);
            var_dump($user);
            if(!$user) {
                $this->alert->addError("Vos identifiants sont incorrects.");
            } else {
                if($user[0]->getRoleId() == ROLE_VISITOR) {
                    $this->alert->addError("Vous devez d'abord valider votre compte.");
                } else {
                    if(password_verify($post->get('password'), $user[0]->getPassword())) {
                        $objDateTime = new DateTime('NOW');
                        $date = $objDateTime->format('Y-m-d H:i:s');
                        echo $user[0]->getId();             
                        $this->userDAO->updateUser($user[0]->getId(), 'last_connexion', $date);
                        $this->alert->addSuccess("Content de vous revoir.");
                        $this->session->set('id', $user[0]->getId());
                        $this->session->set('role_id', $user[0]->getRoleId());
                        $this->session->set('pseudo', $user[0]->getPseudo());
                        ($this->checkAdmin())? header("Location: ".URL."admin") : header("Location: ".URL."profil");
                        exit;
                    }
                }
            }
        }
        return $this->view->render($this->controller, 'login', [
            'post'=> $post
        ]);
    }
}