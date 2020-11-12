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
    private $errors = [];

    public function home()
    {
        $articles = $this->articleDAO->getArticlesBy('lasts', NB_LAST_ARTICLES);
        $categories = Search::lookForOr($this->categoryDAO->getCategories(), [
            'status' => MAIN_CATEGORY
        ]);
        return $this->view->render($this->controller, 'home', [
           'articles' => $articles,
           'categories' => $categories,
           'errors' => $this->errors
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
        if($post->get('submit')) {   
            $this->errors = $this->validation->validate($post, 'User'); 
            if (!$this->errors) {
                if(!Search::lookForOr($this->userDAO->getUsers(), [
                    'pseudo' => $post->get('pseudo'),
                    'email' => $post->get('email')
                ])) {
                    $objDateTime = new DateTime('NOW');
                    $date = $objDateTime->format('Y-m-d H:i:s');
                    $token = password_hash($date.$post->get('pseudo'), PASSWORD_BCRYPT);
                    $idUser = $this->userDAO->addUser($post, $date, $token);
                    if($idUser) {
                        $this->sendMail($post, $token);
                        header("location: ".URL."accueil");
                        exit;
                    } else {
                        $this->errors = ['request' => 'Il y a eu un problème avec votre inscription'];
                    }    
                } else {
                    $this->errors = ['pseudo' => 'Le pseudo existe déjà ou l\'adresse email existe(nt) déjà.'];
                }
            }
        }
        return $this->view->render($this->controller, 'register', [
            'post' => $post,
            'errors' => $this->errors
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
        if(!empty($user)) {
            $this->userDAO->updateUser($user[0]->getId(), 'role_id', ROLE_MEMBER);
        }
        header("Location: ".URL."accueil");
        exit;
    }
}
