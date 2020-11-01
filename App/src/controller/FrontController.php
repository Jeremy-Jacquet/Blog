<?php

namespace App\src\controller;

class FrontController extends Controller
{
    private $controller = 'front';

    public function home()
    {
        $articles = $this->articleDAO->getLastArticles(NB_LAST_ARTICLES);
        $categories = $this->categoryDAO->getCategories('highlight');
        return $this->view->render($this->controller, 'home', [
           'articles' => $articles,
           'categories' => $categories
        ]);
    }

    public function categories()
    {
        $categoriesHighlight = $this->categoryDAO->getCategories('highlight');
        $categoriesActive = $this->categoryDAO->getCategories('active');
        return $this->view->render($this->controller, 'categories', [
           'categoriesHighlight' => $categoriesHighlight,
           'categoriesActive' =>$categoriesActive
        ]);
    }
}
