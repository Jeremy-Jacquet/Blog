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
        if($this->categoryDAO->existsCategory($id)) {
            $articles = Search::lookForOr($this->articleDAO->getArticles(), [
                'categoryId' => $id
            ]);
            $category = $this->categoryDAO->getCategory($id);
            return $this->view->render($this->controller, 'articlesByCategory', [
            'articles' => $articles,
            'category' => $category
            ]);
        } else {
            header("Location: ".URL."articles");
            exit;
        }    
    }

    public function single($id)
    {
        $article = Search::lookForOr($this->articleDAO->getArticles(), [
            'id' => $id
        ]);
        if(!empty($article)) {
            return $this->view->render($this->controller, 'single', [
            'article' => $article[0]
            ]);
        } else {
            header("Location: ".URL."articles");
            exit;
        }
    }

    public function register(Parameter $post = null)
    {
        if($this->checkLoggedIn()) {
            $this->alert->addError('Vous possédez déjà un compte.');
            header("Location: ".URL."accueil");
            exit;
        } elseif($post->get('submit')) { 
            $error = $this->validation->validate($post, 'User'); 
            if(!$error) {
                if(!Search::lookForOr($this->userDAO->getUsers(), [
                    'pseudo' => $post->get('pseudo'),
                    'email' => $post->get('email')
                    ])) {
                    $objDateTime = new DateTime('NOW');
                    $date = $objDateTime->format('Y-m-d H:i:s');
                    $token = password_hash($date.$post->get('pseudo'), PASSWORD_BCRYPT);
                    if($this->userDAO->addUser($post, $date, $token)) {
                        $this->sendMail($post, $token);
                        header("location: ".URL."accueil");
                        exit;
                    } else {
                        $this->alert->addError('Il y a eu un problème avec votre inscription');
                    }
                }
            } else {
                $this->alert->addError($error);
            }
        }
        return $this->view->render($this->controller, 'register', [
            'post' => $post
        ]);       
    }

    public function sendMail(Parameter $post, $token)
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
        if($user) {
            $this->userDAO->updateUser($user[0]->getId(), 'role_id', ROLE_MEMBER);
            $this->userDAO->updateUser($user[0]->getId(), 'token', NULL);
            $this->alert->addSuccess('Félicitations, vous êtes bien inscrit.');            
            header("Location: ".URL."accueil");
            exit; 
        } else {
            $this->alert->addError('Votre inscription n\'a pas aboutie.');
            header("Location: ".URL."inscription");
            exit; 
        }       
    }

    public function login(Parameter $post)
    {
        if($this->checkLoggedIn()) {
            $this->alert->addError('Vous êtes déjà connecté.');
        } elseif($post->get('submit')) {
            $user = Search::lookForOr($this->userDAO->getUsers(), [
                'pseudo' => $post->get('pseudo')
            ]);
            if($user AND password_verify($post->get('password'), $user[0]->getPassword())) {
                $objDateTime = new DateTime('NOW');
                $date = $objDateTime->format('Y-m-d H:i:s');
                $this->userDAO->updateUser($user[0]->getId(), 'last_connexion', $date);
                $this->alert->addSuccess('Content de vous revoir.');
                $this->session->set('id', $user[0]->getId());
                $this->session->set('role_id', $user[0]->getRoleId());
                $this->session->set('pseudo', $user[0]->getPseudo());
            } else {
                $this->alert->addError('Vos identifiants sont incorrects.');
                return $this->view->render($this->controller, 'login', [
                    'post'=> $post
                ]);
            }
        } else {
            return $this->view->render($this->controller, 'login');
        }
        ($this->checkAdmin())? header("Location: ".URL."admin") : header("Location: ".URL."accueil");
    }
}
