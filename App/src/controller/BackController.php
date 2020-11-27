<?php

namespace App\src\controller;

use App\src\blogFram\Image;
use App\src\blogFram\Parameter;
use App\src\blogFram\Search;

/**
 * BackController
 */
class BackController extends Controller
{    
    /**
     * @var string
     */
    private $controller = 'back';
    
    /**
     * Logout user
     *
     * @return void
     */
    public function logout()
    {
        $this->session->stop();
        $this->session->start();
        $this->alert->addSuccess("A bientôt!");
        header("Location: ".URL."accueil");
    }
    
    /**
     * Get profile page
     *
     * @param  Parameter $post
     * @return mixed $view
     */
    public function profile(Parameter $post)
    {
        if(!$this->checkLoggedIn()) {
            $this->alert->addError("Vous devez être connecté pour accéder à cette section.");
            header("Location: ".URL."connexion");
            exit;
        }
        if($post->get('submit')) {
            $this->updateAccount($post);
        }
        return $this->view->render($this->controller, 'profile', [
            'user' => $this->userDAO->getUser($this->session->get('id'))
        ]); 
    }
    
    /**
     * Get admin dashboard page
     *
     * @return mixed $view
     */
    public function dashboard()
    {
        if(!$this->checkAdmin()) {
            $this->alert->addError("Vous n'avez pas le droit d'accéder à cette page.");
            header("Location: ".URL."accueil");
            exit;
        } else {
            $pendingArticles = Search::lookForOr($this->articleDAO->getArticles(),[
                'status' => PENDING_ARTICLE
            ]);
            $pendingComments = Search::lookForOr($this->commentDAO->getComments(),[
                'status' => PENDING_COMMENT
            ]);
            return $this->view->render($this->controller, 'dashboard', [
                'users' => $this->userDAO->getUsers(),
                'pendingArticles' => $pendingArticles,
                'pendingComments' => $pendingComments
            ]);
        }  
    }
    
    /**
     * Update user account by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function updateAccount(Parameter $post)
    {
        if($post->get('submit')) {
            if($post->get('delete')) {
                $this->updateAccountDelete($post);
            } elseif($post->get('password')) {
                $this->updateAccountPassword($post);
            } elseif($post->get('email')) {
                $this->updateAccountEmail($post);
            } elseif($post->get('avatar')) {
                $this->updateAccountAvatar($post);
            } elseif($post->get('newsletter')) {
                $this->updateAccountNewsletter($post);
            }         
        }
    }
    
    /**
     * Update user password by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function updateAccountPassword(Parameter $post)
    {
        if($post->get('password') AND $post->get('passwordConfirm')) {
            $validate = $this->validation->validateInput('user', $post);
            if($validate) {
                $passwordHash = password_hash($post->get('password'), PASSWORD_BCRYPT);
                if($this->userDAO->updateUser($this->session->get('id'), 'password', $passwordHash)) {
                    $this->alert->addSuccess("Votre mot de passe a bien été modifié.");
                } else {
                    $this->alert->addError("Votre mot de passe n'a pas pu être modifié.");
                }
            } 
        }
    }
    
    /**
     * Update user email by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function updateAccountEmail(Parameter $post)
    {
        if($post->get('email')) {
            $validate = $this->validation->validateInput('user', $post);
            if($validate) {
                if($this->userDAO->updateUser($this->session->get('id'), 'email', $post->get('email'))) {
                    $this->alert->addSuccess("Votre adresse mail a bien été modifiée.");
                } else {
                    $this->alert->addError("Votre email n'a pas pu être modifiée.");
                }
            }
        }
    }
    
    /**
     * update user avatar by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function updateAccountAvatar(Parameter $post) 
    {
        if($post->get('avatar')) {
            $image = new Image('avatar', $_FILES['avatar'], $this->session->get('id'));
            if($image->checkImage('avatar', $_FILES['avatar'], $image::TARGET_AVATAR)) {
                if($image->upload($_FILES['avatar'])) {
                    if($this->userDAO->updateUser($this->session->get('id'), 'filename', $image->getFilename())) {
                        $this->alert->addSuccess("Votre avatar a bien été modifié.");                        
                    } else {
                        $this->alert->addError("Votre avatar n'a pas pu être modifié.");
                    }
                }
            }
        }
    }

    /**
     * Update user newsletter subscription by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function updateAccountNewsletter(Parameter $post) 
    {
        if($post->get('newsletter')) {
            if($post->get('newsletter') === 'on') {
                if($this->userDAO->updateUser($this->session->get('id'), 'newsletter', 1)) {
                    $this->alert->addSuccess("Merci de vous être abonné à la newsletter.");
                } else {
                    $this->alert->addError("Une erreur a empêché votre abonnement à la newsletter.");
                }
            } elseif($post->get('newsletter') === 'off') {
                if($this->userDAO->updateUser($this->session->get('id'), 'newsletter', 0)) {
                    $this->alert->addSuccess("Vous êtes bien désabonné de la newsletter.");
                } else {
                    $this->alert->addError("Une erreur a empêché votre désabonnement à la newsletter.");
                }
            }
        }
    }
    
    /**
     * Delete user account by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function updateAccountDelete(Parameter $post)
    {
        if($post->get('delete')) {
            if(!$post->get('deleteConfirm')) {
                $this->alert->addError("Vous n'avez pas confirmé le souhait de supprimer votre compte.");
            } else {
                if($this->validation->validateInput('user', $post)) {
                    $id = $this->session->get('id');
                    $passwordHash = $this->userDAO->getUser($id)->getPassword();
                    if(!password_verify($post->get('password'), $passwordHash)) {
                        $this->alert->addError("Votre mot de passe n'est pas bon");
                    } else {
                        $this->userDAO->deleteUser($id);
                        if($this->userDAO->existsUser($id)) {
                            $this->alert->addError("Votre compte n'a pas pu être supprimé.");
                        } else {
                            $this->logout();
                        }
                    }
                }
            }
        }
    }
    
    /**
     * Display users for administration
     *
     * @param  Parameter $post
     * @return void|mixed $view
     */
    public function displayUsers(Parameter $post)
    {
        if(!$this->checkAdmin()) {
            $this->alert->addError("Vous n'avez pas le droit d'accéder à cette page.");
            header("Location: ".URL."accueil");
            exit;
        }
        if(!$post->get('submit') OR $post->get('delete')) {
            if($post->get('delete')) {
                $this->deleteUser($post);
            }
            return $this->view->render($this->controller, 'users', [
                'users' => $this->userDAO->getUsers()
            ]);
        }
        if($post->get('update')) {
            $this->updateUser($post);
        }
        $user = $this->userDAO->getUser($post->get('id'));
        return $this->view->render($this->controller, 'user', [
            'user' => $user
        ]);
    }
    
    /**
     * Delete user by administrator
     *
     * @param  Parameter $post
     * @return void
     */
    public function deleteUser(Parameter $post)
    {
        if($post->get('delete')) {
            if(!$post->get('deleteConfirm')) {
                $this->alert->addError("Vous n'avez pas confirmé la suppression de l'utilisateur.");
            } else {
                $id = $post->get('id');
                $this->userDAO->deleteUser($id);
                if($this->userDAO->existsUser($id)) {
                    $this->alert->addError("L'utilisateur n'a pas pu être supprimé.");
                } else {  
                    $this->alert->addSuccess("L'utilisateur a bien été supprimé.");
                }
            }
        }
    }
    
    /**
     * Update user by administrator
     *
     * @param  Parameter $post
     * @return void
     */
    public function updateUser(Parameter $post)
    {
        $id = $post->get('id');
        $post->delete(['id', 'submit']);
        $attributesArray = [
            'pseudo',  
            'email', 
            'filename', 
            'newsletter', 
            'flag', 
            'banned', 
            'role_id'
        ];
        if($this->validation->validateInput('user', $post)) {                       
            foreach($attributesArray as $index => $attribute) {
                $value = $post->get($attribute);
                if(!$this->userDAO->updateUser($id, $attribute, $value)) {
                    $this->alert->addError("Le champ $attribute n'a pas pu être modifié.");
                }
            }
        }
        $post->set('id', $id);
    }
    
    
    /**
     * Add comment by user
     *
     * @param  Parameter $post
     * @return void
     */
    public function addComment(Parameter $post)
    {
        if(!$this->checkLoggedIn()) {
            $this->alert->addError("Vous devez être connecté pour laisser un commentaire");
            header("Location: ".URL."connexion");
            exit;
        }
        if(!$this->validation->validateInput('comment', $post)) {
            $this->session->set('comment', $post->get('comment'));
            header("Location:".URL."articles&id=".$post->get('articleId')."#comment");
            exit;
        } else {
            if($this->commentDAO->addComment($post, $this->date)) {
                $this->alert->addSuccess("Merci, votre commentaire est soumis à validation.");
                header("Location:".URL."articles");
                exit;
            }
        }
    }

}
