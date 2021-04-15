<?php
namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Alert;
use App\src\blogFram\Image;
use App\src\constraint\Validation;
use App\src\DAO\ArticleDAO;

class ArticleController
{
    private $alert;
    private $validation;
    private $articleDAO;

    public function __construct($alert, $validation)
    {
        $this->alert = $alert;
        $this->validation = $validation;
        $this->articleDAO = new ArticleDAO;
    }

    public function addArticle($post)
    { 
        $newArticleId = $this->articleDAO->addArticle($post);
        return $newArticleId;
    }

    public function updateArticle($post)
    {
        $isSuccess = $this->articleDAO->updateArticle($post);
        return $isSuccess;
    }

    public function deleteArticle($post)
    {
        $isSuccess = $this->articleDAO->deleteArticle($post);
        return $isSuccess;
    }

    public function getOneArticle($articleId)
    {
        $article = $this->articleDAO->getOneArticle($articleId);
        return $article;
    }
    
    /**
     * getArticles
     *
     * @param  array|string $attributes (ex: 'all' or [['name' => status, 'value' => 1, 'parameter' => 'integer']])
     * @param  int $limit
     * @param  int $start
     * @return void
     */
    public function getArticles($attributes, $limit = null, $start = null)
    {
        $articles = $this->articleDAO->getArticles($attributes, $limit, $start);
        return $articles;
    }

    public function getLastArticles($numberOfArticles)
    {
        $lastArticles = $this->articleDAO->getLastArticles($numberOfArticles);
        return $lastArticles;
    }
    
    /**
     * count articles
     *
     * @param  array $attributes
     * @return int
     */
    public function countArticles($attributes)
    {
        return $this->articleDAO->countArticles($attributes);
    }

}
