<?php

namespace App\src\controller;

class ErrorController extends Controller
{
    public $controller = 'error';
    public $title = 'Erreur';

    public function errorNotFound()
    {
        return $this->view->render($this->controller, 'error_404');
    }

    public function errorServer()
    {
        return $this->view->render($this->controller, 'error_500');
    }
}