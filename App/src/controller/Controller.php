<?php

namespace App\src\controller;

use App\src\blogFram\Request;
use App\src\blogFram\View;
use App\src\blogFram\Alert;
use App\src\blogFram\Image;
use App\src\constraint\Validation;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CategoryDAO;
use App\src\DAO\UserDAO;
use App\src\DAO\CommentDAO;


abstract class Controller
{
    protected $request;
    protected $get;
    protected $post;
    protected $session;
    protected $view;
    protected $articleDAO;
    protected $categoryDAO;
    protected $userDAO;
    protected $commentDAO;
    protected $validation;
    protected $alert;
    
    

    public function __construct()
    {
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->session = $this->request->getSession();
        $this->view = new View();
        $this->articleDAO = new ArticleDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->userDAO = new UserDAO();
        $this->commentDAO = new CommentDAO();
        $this->validation = new Validation();
        $this->alert = new Alert();
    }

    protected function checkLoggedIn()
    {
        if($this->session->get('pseudo')) {
            return true;
        }
    }

    protected function checkAdmin()
    {
        $this->checkLoggedIn();
        if($this->session->get('role_id') === ROLE_ADMIN) {
            return true;
        }
    }
}