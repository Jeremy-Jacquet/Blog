<?php

namespace App\src\router;

/**
 * Security
 */
class RequestSecurity
{    
    // Retirer 'test' de ROUTE
    const ROUTE = ['accueil', 'blog', 'categories', 'inscription', 'connexion', 'deconnexion', 'profil', 'admin'];
    const CATEGORIE = ['articles', 'categories', 'membres', 'commentaires'];
    const ACTION = ['ajouter', 'modifier', 'supprimer'];

    const REGISTER = ['pseudo', 'password', 'password2', 'email'];
    const LOGIN  = ['pseudo', 'password'];

    const ADD_ARTICLE = ['title', 'sentence', 'content', 'filename', 'author_id', 'category_id', 'status'];
    const ADD_CATEGORY = ['title', 'sentence', 'filename', 'status'];
    const ADD_COMMENT  = ['content', 'article_id', 'user_id', 'status'];

    const UPDATE_ARTICLE = ['title', 'sentence', 'content', 'filename', 'updated_at', 'author_id_who_updated', 'category_id', 'status'];
    const UPDATE_CATEGORY = ['title', 'sentence', 'filename', 'status'];
    const UPDATE_COMMENT = ['status'];
    const UPDATE_USER = ['flag', 'ban', 'level'];
    const UPDATE_ACCOUNT = ['password', 'email', 'avatar'];

    const DELETE = ['id'];

    public function checkIfAutorizeParameterGet()
    {
        $error = 0;
        if(isset($_GET['route'])) {
            $error = (in_array($_GET['route'], self::ROUTE, true))? $error : $error +1;
        }
        if(isset($_GET['categorie'])) {
            $error = (in_array($_GET['categorie'], self::CATEGORIE, true))? $error : $error +1;
        }
        if(isset($_GET['action'])) {
            $error = (in_array($_GET['action'], self::ACTION, true))? $error : $error +1;
        }
        return ($error === 0)? true : false;
    }

    public function checkIfAutorizeParameterPost()
    {   
        $isAuthorized = false;
        if($_POST['submit']) {
            if(isset($_POST['register'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::REGISTER, true);
            } elseif(isset($_POST['login'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::LOGIN, true);
            } elseif(isset($_POST['add_article'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::ADD_ARTICLE, true);
            } elseif(isset($_POST['add_category'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::ADD_CATEGORY, true);
            } elseif(isset($_POST['add_comment'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::ADD_COMMENT, true);
            } elseif(isset($_POST['update_article'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::UPDATE_ARTICLE, true);
            } elseif(isset($_POST['update_category'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::UPDATE_CATEGORY, true);
            } elseif(isset($_POST['update_comment'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::UPDATE_COMMENT, true);
            } elseif(isset($_POST['update_user'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::UPDATE_USER, true);
            } elseif(isset($_POST['update_account'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::UPDATE_ACCOUNT, true);
            } elseif(isset($_POST['delete'])) {
                $isAuthorized = $this->checkIfInputsAreInArray(self::DELETE, true);       
            }
        } 
        return $isAuthorized;
    }

    public function checkIfInputsAreInArray($constArray, $strict)
    {
        $postArray = [];
        foreach($_POST as $key => $value) {
            $postArray[] = $key; 
        }
        $error = 0;
        foreach($constArray as $value) {
            $isSuccess = in_array($value, $postArray, $strict);
            $error = ($isSuccess)? $error : $error +1;
        }
        return ($error === 0)? true : false;
    }

    public function filterGet()
    {
        $getArray = [];
        if(isset($_GET['route'])) {
            $getArray['route'] = filter_input(INPUT_GET, 'route', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_GET['categorie'])) {
            $getArray['categorie'] = filter_input(INPUT_GET, 'categorie', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_GET['action'])) {
            $getArray['action'] = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        if(isset($_GET['id'])) {
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            $getArray['id'] = (int)$id;
        }
        return $getArray;
    }

    public function filterPost()
    {
        if(isset($_POST['register'])) {
            $postArray = $this->filterRegisterInputs();
        } elseif(isset($_POST['login'])) {
            $postArray = $this->filterLoginInputs();
        } elseif(isset($_POST['add_article'])) {
            $postArray = $this->filterAddArticleInputs();
        } elseif(isset($_POST['add_category'])) {
            $postArray = $this->filterAddCategoryInputs();
        } elseif(isset($_POST['add_comment'])) {
            $postArray = $this->filterAddCommentInputs();
        } elseif(isset($_POST['update_article'])) {
            $postArray = $this->filterUpdateArticleInputs();
        } elseif(isset($_POST['update_category'])) {
            $postArray = $this->filterUpdateCategoryInputs();
        } elseif(isset($_POST['update_comment'])) {
            $postArray = $this->filterUpdateCommentInputs();
        } elseif(isset($_POST['delete'])) {
            $postArray = $this->filterAddArticleInputs();     
        }
        return $postArray;
    }

    public function filterRegisterInputs()
    {
        $postArray = [];
        $postArray['pseudo'] = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['password2'] = filter_input(INPUT_POST, 'password2', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        return $postArray;
    }

    public function filterLoginInputs()
    {
        $postArray = [];
        $postArray['pseudo'] = filter_input(INPUT_POST, 'pseudo', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        return $postArray;
    }

    public function filterAddArticleInputs()
    {
        $postArray = [];
        $postArray['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['sentence'] = filter_input(INPUT_POST, 'sentence', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['authorId'] = filter_input(INPUT_POST, 'author_id', FILTER_SANITIZE_NUMBER_INT);
        $postArray['categoryId'] = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        $postArray['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
        return $postArray;
    }

    public function filterAddCategoryInputs()
    {
        $postArray = [];
        $postArray['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['sentence'] = filter_input(INPUT_POST, 'sentence', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
        return $postArray;
    }

    public function filterAddCommentInputs()
    {
        $postArray = [];
        $postArray['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['articleId'] = filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_NUMBER_INT);
        $postArray['userId'] = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $postArray['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);
        return $postArray;
    }

    public function filterUpdateArticleInputs()
    {
        if($this->checkIfValidateDate($_POST['updated_at'])) {
            $postArray = [];
            $postArray['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $postArray['sentence'] = filter_input(INPUT_POST, 'sentence', FILTER_SANITIZE_SPECIAL_CHARS);
            $postArray['content'] = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
            $postArray['authorIdWhoUpdated'] = filter_input(INPUT_POST, 'author_id_who_updated', FILTER_SANITIZE_NUMBER_INT);
            $postArray['categoryId'] = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
            $postArray['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT); 
            return $postArray;
        }
        return false;
    }

    public function filterUpdateCategoryInputs()
    {
        $postArray = [];
        $postArray['title'] = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['sentence'] = filter_input(INPUT_POST, 'sentence', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['categoryId'] = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_NUMBER_INT);
        $postArray['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT); 
        return $postArray;  
    }

    public function filterUpdateCommentInputs()
    {
        $postArray = [];
        $postArray['status'] = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);  
        return $postArray; 
    }

    public function filterUpdateMemberInputs()
    {
        $postArray = [];
        $postArray['flag'] = filter_input(INPUT_POST, 'flag', FILTER_SANITIZE_NUMBER_INT);
        $postArray['ban'] = filter_input(INPUT_POST, 'ban', FILTER_SANITIZE_NUMBER_INT);
        $postArray['level'] = filter_input(INPUT_POST, 'level', FILTER_SANITIZE_NUMBER_INT);
        return $postArray; 
    }

    public function filterUpdateAccountInputs()
    {
        $postArray = [];
        $postArray['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
        $postArray['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        return $postArray; 
    }

    
    public function checkIfValidateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = \DateTime::createFromFormat($format, $date);
        if($d && $d->format($format) == $date) {
            return true;
        }
        return false;
    }
    

    /*
    public function secureArray($array) 
    {
        $secureArray = [];
        foreach($array as $key => $value) {
            $secureArray[$key] = $this->secureData($value);
        }
        return $secureArray;
    }

    public function secureData($data) 
    {
        $secureData = trim($data);
        $secureData = stripslashes($secureData);
        $secureData = htmlspecialchars($secureData);
        return $secureData;
    }
    */

}
