<?php

namespace App\src\controller;

class FrontController extends Controller
{
    private $controller = 'front';

    public function home()
    {
        $title = 'Blog - Webaby';
        $articles = $this->articleDAO->getLastArticles(NB_LAST_ARTICLES);
        $categories = $this->categoryDAO->getCategories(true);
        return $this->view->render($this->controller, 'home', [
           'articles' => $articles,
           'categories' => $categories
        ]);
    }
}
