<?php

namespace App\src\controller;

use App\src\blogFram\Request;
use App\src\blogFram\View;
use App\src\blogFram\Alert;
use App\src\blogFram\Mailer;
use App\src\constraint\Validation;
use App\src\DAO\ArticleDAO;
use App\src\DAO\CategoryDAO;
use App\src\DAO\UserDAO;
use App\src\DAO\CommentDAO;
use \DateTime;

/**
 * Controller
 */
abstract class Controller
{    
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Parameter
     */
    protected $get;

    /**
     * @var Parameter
     */
    protected $post;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var View
     */
    protected $view;

    /**
     * @var ArticleDAO
     */
    protected $articleDAO;

    /**
     * @var CategoryDAO
     */
    protected $categoryDAO;

    /**
     * @var UserDAO
     */
    protected $userDAO;

    /**
     * @var Comment
     */
    protected $commentDAO;

    /**
     * @var Validation
     */
    protected $validation;

    /**
     * @var Alert
     */
    protected $alert;

    /**
     * @var Mailer
     */
    protected $mailer;

    /**
     * @var \DateTime
     */
    protected $date;
    
    
    /**
     * Construct Controller
     *
     * @return void
     */
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
        $this->mailer = new Mailer();
        $this->setDate();
    }
    
    /**
     * Set protected date (format: Y-m-d H:i:s)
     *
     * @return void
     */
    private function setDate(){
        $objDateTime = new DateTime('NOW');
        $this->date = $objDateTime->format('Y-m-d H:i:s');
    }
    
    /**
     * Get protected date (format: Y-m-d H:i:s)
     *
     * @return \DateTime protected $date
     */
    protected function getDate() {
        return $this->date;
    }
    
    /**
     * Check if user is logged
     *
     * @return void|true (true if session->get('pseudo'))
     */
    protected function checkLoggedIn()
    {
        if($this->session->get('pseudo')) {
            return true;
        }
    }
    
    /**
     * Check if user is an Admin
     *
     * @return void|true (true if session->get('level') >= ADMIN_LEVEL))
     */
    protected function checkAdmin()
    {
        $this->checkLoggedIn();
        if($this->session->get('level') >= ADMIN_LEVEL) {
            return true;
        }
    }
}