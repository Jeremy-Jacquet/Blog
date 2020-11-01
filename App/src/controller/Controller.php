<?php

namespace App\src\controller;

use App\src\blogFram\Request;
use App\src\blogFram\View;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CategoryDAO;

abstract class Controller
{
    protected $request;
    protected $get;
    protected $post;
    protected $view;
    protected $articleDAO;
    protected $categoryDAO;

    public function __construct()
    {
        $this->request = new Request();
        $this->get = $this->request->getGet();
        $this->post = $this->request->getPost();
        $this->view = new View();
        $this->articleDAO = new ArticleDAO();
        $this->categoryDAO = new CategoryDAO();
    }
}