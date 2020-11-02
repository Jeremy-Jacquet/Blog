<?php

namespace App\src\controller;

class FrontController extends Controller
{
    private $controller = 'front';

    public function home()
    {
        $articles = $this->articleDAO->getLastArticles(NB_LAST_ARTICLES);
        $categories = $this->categoryDAO->getCategories(MAIN_CATEGORY);
        return $this->view->render($this->controller, 'home', [
           'articles' => $articles,
           'categories' => $categories
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
        $articles = $this->articleDAO->getArticlesByCategory($categoryId);
        $category = $this->categoryDAO->getCategory($categoryId);
        return $this->view->render($this->controller, 'articlesByCategory', [
           'articles' => $articles,
           'category' => $category
        ]);
    }

    public function single($id)
    {
        $article = $this->articleDAO->getArticle($id);
        return $this->view->render($this->controller, 'single', [
           'article' => $article
        ]);
    }
}
