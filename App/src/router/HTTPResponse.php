<?php

namespace App\src\router;

use App\src\blogFram\Parameter;
use App\src\controller\BackController;
use App\src\controller\FrontController;

/**
 * HTTPResponse
 */
class HTTPResponse 
{        
    private $get;
    private $post;
    private $file;
    private $frontController;
    private $backController;

    public function __construct($get, $post, $file)
    {
        $this->get = $get;
        $this->post = $post;
        $this->file = $file;
        $this->frontController = new FrontController($get, $post, $file);
        $this->backController = new BackController($get, $post, $file);
    }

    /**
     * display view
     *
     * @param  Parameter $get
     * @return void
     */
    public function displayView()
    {
        if($this->isValidatedParameters()) {
            if($this->get->get('route')) {
                if($this->get->get('route') === 'accueil') {
                    $this->frontController->goToHome();
                } elseif($this->get->get('route') === 'blog') {
                    $this->goToBlog();
                } elseif($this->get->get('route') === 'categories') {
                    $this->goToCategories();
                } elseif($this->get->get('route') === 'inscription') {
                    $this->goToRegister();
                } elseif($this->get->get('route') === 'connexion') {
                    $this->frontController->goToLoginForm();
                } elseif($this->get->get('route') === 'deconnexion') {
                    $this->frontController->goToLogout();
                } elseif($this->get->get('route') === 'profil') {
                    $this->backController->goToProfile();
                } elseif($this->get->get('route') === 'admin') {
                    $this->goToAdmin();
                }
            } else {
                $this->frontController->goToHome();
            }
        } else {
            echo 'ERROR NOT FOUND';
        }
    }
    
    /**
     * go to blog
     *
     * @return void
     */
    public function goToBlog()
    {
        if($this->get->get('id')) {
            $this->frontController->goToSingle();
        } elseif($this->post->get('submit')) {
            $this->backController->goToAddComment();
        } else {
            $this->frontController->goToBlog();
        }
    }
    
    /**
     * go to categories
     *
     * @return void
     */
    public function goToCategories()
    {
        if($this->get->get('id')) {
            $this->frontController->goToArticlesByCategory();
        } else {
            $this->frontController->goToCategories();
        }
    }
    
    /**
     * go to register
     *
     * @return void
     */
    public function goToRegister()
    {
        if($this->get->get('action') === 'confirmation') {
            $this->frontController->goToConfirmRegister();
        } else {
            $this->frontController->goToRegisterForm();
        }
    }
    
    /**
     * go to admininistration
     *
     * @return void
     */
    public function goToAdmin()
    {
        if($this->get->get('categorie') === 'articles') {
            $this->displayArticlesAdmin();
        } elseif($this->get->get('categorie') === 'categories') {
            $this->displayCategoriesAdmin();
        } elseif($this->get->get('categorie') === 'commentaires') {
            $this->displayCommentsAdmin();
        } elseif($this->get->get('categorie') === 'membres') {
            $this->displayUsersAdmin();
        } else {
            $this->backController->goToDashboard();
        }
    }
    
    /**
     * display articles admininistration
     *
     * @return void
     */
    public function displayArticlesAdmin()
    {
        if($this->get->get('action') === 'ajouter') {
            $this->backController->goToAddArticle();
        } elseif($this->get->get('action') === 'modifier') {
            $this->backController->goToUpdateArticle(); 
        } elseif($this->get->get('action') === 'supprimer') {
            $this->backController->goToDeleteArticle(); 
        }else {
            $this->backController->goToDisplayArticles();
        }
    }
    
    /**
     * display categories admininistration
     *
     * @return void
     */
    public function displayCategoriesAdmin()
    {
        if($this->get->get('action') === 'ajouter') {
            $this->backController->goToAddCategory(); 
        } elseif($this->get->get('action') === 'modifier') {
            $this->backController->goToUpdateCategory(); 
        } elseif($this->get->get('action') === 'supprimer') {
            $this->backController->goToDeleteCategory(); 
        } else {
            $this->backController->goToDisplayCategories();
        }
    }

    public function displayUsersAdmin()
    {
        if($this->get->get('action') === 'modifier') {
            $this->backController->goToUpdateUserByAdmin(); 
        } elseif($this->get->get('action') === 'supprimer') {
            $this->backController->goToDeleteUserByAdmin(); 
        } else {
            $this->backController->goToDisplayUsers();
        }
    }

    /**
     * display comments admin
     *
     * @return void
     */
    public function displayCommentsAdmin()
    {
        if($this->get->get('action') === 'modifier') {
            $this->backController->goToUpdateComment(); 
        } elseif($this->get->get('action') === 'supprimer') {
            $this->backController->goToDeleteComment(); 
        } else {
            $this->backController->goToDisplayComments();
        }
    }

    public function isValidatedParameters()
    {
        $isValidatedGet = $this->checkParameterGet();
        $isValidatedPost = $this->checkParameterPost();
        return ($isValidatedGet AND $isValidatedPost)? true : false;
    }
    
    public function checkParameterGet()
    {
        return ($this->get === 'notValid')? false : true;
    }

    public function checkParameterPost()
    {
        return ($this->post === 'notValid')? false : true;
    }

}
