<?php

namespace App\src\blogFram;

use Exception;
use App\src\controller\FrontController;
use App\src\controller\BackController;
use App\src\controller\ErrorController;
use \DateTime;

class Router
{
    private $request;
    private $frontController;
    private $backController;
    private $errorController;

    public function __construct()
    {
        $this->request = new Request();
        $this->frontController = new FrontController();
        $this->backController = new BackController();
        $this->errorController = new ErrorController();
    }

    public function run()
    {
        $route = $this->request->getGet()->get('route');
        $category = (int)$this->request->getGet()->get('categorie');
        $id = (int)$this->request->getGet()->get('id');
        $post = isset($_POST)? $this->request->getPost() : null;
        $action = ($this->request->getGet()->get('action'))? $this->request->getGet()->get('action') : false;
        $token = ($this->request->getGet()->get('token'))? $this->request->getGet()->get('token') : false;
        $email = ($this->request->getGet()->get('email'))? $this->request->getGet()->get('email') : false;

        try {
            if(isset($route)) {
                if($route === 'accueil') {
                    $this->frontController->home();
                } 
                elseif($route === 'categories') {
                    $this->frontController->categories();
                }
                elseif($route === 'articles') {
                    if($category) {
                        $this->frontController->articlesByCategory($category);
                    } elseif($id) {
                        $this->frontController->single($id);
                    } else {
                        $this->frontController->articles();
                    }
                } 
                elseif($route === 'inscription') {
                    if($action === 'confirmation' AND $email AND $token) {
                        $this->frontController->confirmRegister($email, $token);
                    }
                    $this->frontController->register($post);
                }
                elseif($route === 'admin') {
                    $this->backController->dashboard();
                }
                else {
                    $this->errorController->errorNotFound();
                }
            } 
            else {
                $this->frontController->home();
            }
        }
        catch (Exception $e) {
        }
    }
}