<?php

namespace App\src\controller;

use App\src\blogFram\Request;
use App\src\blogFram\View;
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
    protected $view;
    protected $articleDAO;
    protected $categoryDAO;
    protected $userDAO;
    protected $commentDAO;
    protected $validation;
    protected $session;

    public function __construct()
    {
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->view = new View();
        $this->articleDAO = new ArticleDAO();
        $this->categoryDAO = new CategoryDAO();
        $this->userDAO = new UserDAO();
        $this->commentDAO = new CommentDAO();
        $this->validation = new Validation();
        $this->session = $this->request->getSession();
    }
}