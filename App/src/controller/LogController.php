<?php

namespace App\src\controller;

use App\src\blogFram\Session;
use App\src\blogFram\Parameter;
use App\src\blogFram\Alert;
use App\src\blogFram\Mailer;
use App\src\constraint\Validation;
use App\src\controller\UserController;
use App\src\entity\User;
use DateTime;

class LogController
{    
    /**
     * @var UserController
     */
    private $userController;
    
    /**
     * @var Session
     */
    private $session;
        
    /**
     * @var Alert
     */
    private $alert;   

    /**
     * @var Validation
     */
    private $validation;
    
    /**
     * @var Displayer
     */
    private $displayer;

    public function __construct($session, $alert, $validation, $displayer)
    {
        $this->session = $session;
        $this->alert = $alert;
        $this->validation = $validation;
        $this->displayer = $displayer;
        $this->userController = new UserController($session, $alert, $validation);
    }

    /**
     * get login page / Login user
     *
     * @param Parameter $post
     * @return void
     */
    public function login($post)
    {
        if($this->validation->checkInputValidity('user', $post)) {
            $user = $this->userController->checkIfUserExistsBy('pseudo', $post);
            if(!$user) {
                $this->alert->set('error', 'normal', 'main', "Vos identifiants sont incorrects.");
            } else {
                if($user[0]->getLevel() < User::LEVEL['member']) {
                    $this->alert->set('error', 'normal', 'main', "Vous devez d'abord valider votre compte.");
                } else {
                    if(!password_verify($post->get('password'), $user[0]->getPassword())) {
                        $this->alert->set('error', 'normal', 'main', "Vos identifiants sont incorrects.");
                    } else { 
                        $this->alert->set('success', 'normal', 'main', "Content de vous revoir.");
                        $this->session->setUserSession($user[0]);
                        if($this->checkLevel(User::LEVEL['admin'])) {
                            $this->displayer->displayLocation('admin');
                        } else {
                            $this->displayer->displayLocation('profil');
                        }
                    }
                }
            }
        }
    }

    /**
     * logout user
     *
     * @return void
     */
    public function logout()
    {
        $this->session->stop();
        $this->session->start();
        $this->alert->set('success', 'normal', 'main', "A bientôt!");
        header("Location: ".URL."accueil");
        exit;
    }

    /**
     * register user
     *
     * @param  Parameter $post
     * @param  DateTime $date
     * @return void
     */
    public function register($post, $date)
    {
        $userByPseudo = $this->userController->checkIfUserExistsBy('pseudo', $post);
        $userByEmail = $this->userController->checkIfUserExistsBy('email', $post);
        if($userByPseudo OR $userByEmail) {
            $this->alert->set('error', 'normal', 'main', "Veuillez changer d'identifiants.");
        } else {
            $post
                ->set('token', password_hash($date.$post->get('pseudo'), PASSWORD_BCRYPT))
                ->set('created_at', $date);
            if(!$this->userController->addUser($post)) {
                $this->alert->set('error', 'normal', 'main', "Il y a eu un problème avec votre inscription.");
            } else {
                $mailer = new Mailer;
                $mailer->sendMail('register', $post);
                $this->alert->set('success', 'normal', 'main', "Félicitations, un email de confirmation vous a été envoyé.");
            }
        }
    }

    /**
     * confirm registration
     *
     * @param  string $email
     * @param  string $token
     * @return void
     */
    public function confirmRegister($get)
    {
        if($get->get('email') AND $get->get('token')) {
            $user = $this->userController->checkIfUserExistsBy('emailAndToken', $get);
            if(!$user) {   
                $this->alert->set('error', 'normal', 'main', "Votre inscription n'a pas aboutie. Veuillez vérifier que vous n'êtes pas déjà inscrit, ou veuillez vous réinscrire.");
            } else {
                $this->userController->updateUser($user[0]->getId(), 'level', User::LEVEL['member']);
                $this->userController->updateUser($user[0]->getId(), 'token', NULL);
                $this->alert->set('success', 'normal', 'main', "Félicitations, vous êtes bien inscrit."); 
            }
        }
    }

    /**
     * check if user is an Admin
     *
     * @return true|void
     */
    public function checkLevel($role)
    {
        if($this->checkIfIsLoggedIn()) {
            if($this->session->get('level') >= User::LEVEL[$role]) {
                return true;
            }
            $this->alert->set('error', 'high', 'main', "Vous n'avez pas l'autorisation d'accéder à cette page.");
        } else {   
            $this->alert->set('error', 'normal', 'main', "Vous devez d'abord vous connectez.");
        }
        header("Location: ".URL."accueil");
        exit;
    }

    /**
     * check if user is logged
     * can return an alert if $boolean === $result
     * ex: pseudo = true, bool = true => alert = 'success', $message = 'Welcome'
     *
     * @param bool $boolean         condition for alert
     * @param string $alert         only if bool given
     * @param string $message       only if bool given
     * @return bool
     */
    public function checkIfIsLoggedIn($alertIf = null, $alertLevel = null, $alertMessage = null)
    {
        $isLoggedIn = ($this->session->get('pseudo'))? true : false;
        if($alertIf AND $alertLevel AND $alertMessage) {
            if($alertIf === $isLoggedIn) {
                $this->alert->set($alertLevel, 'normal', 'main', $alertMessage);
            }
        }
        return $isLoggedIn;
    }

}
