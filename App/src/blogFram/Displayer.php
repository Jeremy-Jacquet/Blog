<?php

namespace App\src\blogFram;

class Displayer
{    
    /**
     * @var View
     */
    private $view;
    
    /**
     * construct Displayer
     *
     * @param  View $view
     * @return void
     */
    public function __construct($view)
    {
        $this->view = $view;
        return $this;
    }
    
    /**
     * display header($location)
     *
     * @param  mixed $location
     * @return void
     */
    public function displayLocation($location)
    {
        header("Location: ".URL."$location");
        exit;
    }
    
    /**
     * display register
     *
     * @param  Parameter $post
     * @return void
     */
    public function displayRegister($post)
    {
        return $this->view->render('front', false, 'register', [
            'post' => $post
        ]);
    }
    
    /**
     * display login
     *
     * @param  Parameter $post
     * @return void
     */
    public function displayLogin($post)
    {
        return $this->view->render('front', false, 'login', [
            'post'=> $post
        ]);
    }

    /**
     * display home
     *
     * @param  array $articles
     * @param  array $categories
     * @return void
     */
    public function displayHome($articles, $categories)
    {
        return $this->view->render('front', false, 'home', [
            'articles' => $articles,
            'categories' => $categories
        ]);
    }
    
    /**
     * display blog
     *
     * @param  array $articles
     * @param  Pagination $pagination
     * @return void
     */
    public function displayBlog($articles, $pagination)
    {
        return $this->view->render('front', false, 'blog', [
            'articles' => $articles,
            'pagination' => $pagination
        ]);
    }
    
    /**
     * display categories
     *
     * @param  array $mainCategories
     * @param  array $activeCategories
     * @return void
     */
    public function displayCategories($mainCategories, $activeCategories)
    {
        return $this->view->render('front', false, 'categories', [
            'mainCategories' => $mainCategories,
            'activeCategories' => $activeCategories
        ]);
    }
    
    /**
     * display articles by category
     *
     * @param  array $category
     * @param  array $articles
     * @param  Pagination $pagination
     * @return void
     */
    public function displayArticlesByCategory($category, $articles, $pagination)
    {
        return $this->view->render('front', false, 'articlesByCategory', [
            'category' => $category,
            'articles' => $articles,
            'pagination' => $pagination
        ]);
    }
    
    /**
     * display single
     *
     * @param  array $article
     * @param  array $users
     * @param  array $comments
     * @param  mixed $content
     * @return void
     */
    public function displaySingle($article, $users, $comments, $content)
    {
        return $this->view->render('front', false, 'single', [
            'article' => $article,
            'users' => $users,
            'comments' => $comments,
            'content' => $content
        ]);
    }
    
    /**
     * display profile
     *
     * @param  User $user
     * @return void
     */
    public function displayProfile($user)
    {
        return $this->view->render('back', false, 'profile', [
            'user' => $user
        ]);
    }
    
    /**
     * display dashboard
     *
     * @param  array $users
     * @param  array $articles
     * @param  array $comments
     * @return void
     */
    public function displayDashboard($users, $pendingArticles, $pendingComments)
    {
        return $this->view->render('back', true, 'dashboard', [
            'users' => $users,
            'pendingArticles' => $pendingArticles,
            'pendingComments' => $pendingComments
        ]);
    }
    
    /**
     * display user admin
     *
     * @param  User $user
     * @return void
     */
    public function displayUserAdmin($user)
    {
        return $this->view->render('back', true, 'users/update-user', [
            'user' => $user
        ]);
    }
    
    /**
     * display users admin
     *
     * @param  array $users
     * @return void
     */
    public function displayUsersAdmin($users)
    {
        return $this->view->render('back', true, 'users/display-users', [
            'users' => $users
        ]);
    }
    
    /**
     * display categories administration
     *
     * @param  array $categories
     * @return void
     */
    public function displayCategoriesAdmin($categories)
    {
        return $this->view->render('back', true, 'categories/display-categories', [
            'categories' => $categories
        ]);
    }
    
    /**
     * display to add category
     *
     * @return void
     */
    public function displayAddCategory()
    {
        return $this->view->render('back', true, 'categories/add-category');
    }
    
    /**
     * display to update category
     *
     * @param  mixed $category
     * @return void
     */
    public function displayUpdateCategory($category)
    {
        return $this->view->render('back', true, 'categories/update-category', [
            'category' => $category
        ]);
    }
    
    /**
     * display articles administration
     *
     * @param  array $articles
     * @return void
     */
    public function displayArticlesAdmin($articles)
    {
        return $this->view->render('back', true, 'articles/display-articles', [
            'articles' => $articles
        ]);
    }
    
    /**
     * display add article
     *
     * @param  array $categories
     * @return void
     */
    public function displayAddArticle($categories)
    {
        return $this->view->render('back', true, 'articles/add-article', [
            'categories' => $categories
        ]);
    }
    
    /**
     * display to update article
     *
     * @param  mixed $article
     * @return void
     */
    public function displayUpdateArticle($article, $categories)
    {
        return $this->view->render('back', true, 'articles/update-article', [
            'article' => $article,
            'categories' => $categories
        ]);
    }

    /**
     * display comments administration
     *
     * @param  mixed $comments
     * @param  mixed $users
     * @return void
     */
    public function displayCommentsAdmin($comments, $users)
    {
        return $this->view->render('back', true, 'comments/display-comments', [
            'comments' => $comments,
            'users' => $users
        ]);
    }

}
