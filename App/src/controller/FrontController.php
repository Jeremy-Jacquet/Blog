<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Mailer;

class FrontController extends Controller
{

    private $controller = 'front';
    private $mailer;
    private $errors = [];

    public function home()
    {
        $articles = $this->articleDAO->getLastArticles(NB_LAST_ARTICLES);
        $categories = $this->categoryDAO->getCategories(MAIN_CATEGORY);
        return $this->view->render($this->controller, 'home', [
           'articles' => $articles,
           'categories' => $categories,
           'errors' => $this->errors
        ]);
    }

    public function categories()
    {
        $categoriesMain = $this->categoryDAO->getCategories(MAIN_CATEGORY);
        $categoriesActive = $this->categoryDAO->getCategories(ACTIVE_CATEGORY);
        return $this->view->render($this->controller, 'categories', [
           'categoriesMain' => $categoriesMain,
           'categoriesActive' =>$categoriesActive
        ]);
    }

    public function articles()
    {
        $articles = $this->articleDAO->getArticles(ACTIVE_ARTICLE);
        return $this->view->render($this->controller, 'articles', [
           'articles' => $articles
        ]);
    }

    public function articlesByCategory($categoryId)
    {
        if($this->categoryDAO->existsCategory($categoryId)) {
            $articles = $this->articleDAO->getArticlesByCategory($categoryId);
            $category = $this->categoryDAO->getCategory($categoryId);
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
        if($this->articleDAO->existsArticle($id)) {
            $article = $this->articleDAO->getArticle($id);
            return $this->view->render($this->controller, 'single', [
            'article' => $article
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
            var_dump($this->errors);
            if (!$this->errors) {
                $existsUser = $this->userDAO->existsUser($post->get('pseudo'));
                if(!$existsUser) {
                    $dataUser = $this->userDAO->addUser($post);
                    if($dataUser) {
                        $this->sendMail($post, $dataUser);
                        header("location: ".URL."accueil");
                        exit;
                    } else {
                        $this->errors = ['request' => 'Il y a eu un problème avec votre inscription'];
                    }    
                } else {
                    $this->errors = ['pseudo' => 'Le pseudo existe déjà, veuillez en choisir un autre'];
                }
            }
        }
        return $this->view->render($this->controller, 'register', [
            'post' => $post,
            'errors' => $this->errors
        ]);
    }

    public function sendMail(Parameter $post, $dataUser)
    {
        $title = 'Email de confirmation';
        $body = $this->view->renderFile('../App/template/mail/mail_confirmation.php', [
            'title' => $title,
            'pseudo' => $post->get('pseudo'),
            'id' => $dataUser['id'],
            'token' => $dataUser['token']
            ]);
        $this->mailer = new Mailer();
        $this->mailer->setMail($title, FROM_EMAIL, FROM_USERNAME, $post->get('email'), $body);
        $this->mailer->sendMail();
    }

    public function confirmRegister($email, $token)
    {
        $user = $this->userDAO->getUserByMail($email);
        if($user){
            if($token === $user->getToken()) {
                echo'coucou';
                if($this->userDAO->updateUser($user->getId(), 'role_id', ROLE_MEMBER)) {
                    header("location: ".URL."accueil");
                    exit;
                }
            }
        }
        header("Location: ".URL."accueil");
        exit;
    }
}
