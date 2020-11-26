<?php

namespace App\src\controller;

/**
 * ErrorController
 */
class ErrorController extends Controller
{
    /**
     * @var string
     */
    public $controller = 'error';

    /**
     * @var string
     */
    public $title = 'Erreur';
    
    /**
     * Get error 404 page
     *
     * @return mixed $view
     */
    public function errorNotFound()
    {
        return $this->view->render($this->controller, 'error_404');
    }
    
    /**
     * Get error 500 page
     *
     * @return mixed $view
     */
    public function errorServer()
    {
        return $this->view->render($this->controller, 'error_500');
    }
}