<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Search;

class LogController extends Controller
{
    /**
     * Get login page / Login user
     *
     * @param  object $post
     * @return void|mixed $view
     */
    public function login(Parameter $post)
    {
        if($post->get('submit')) {
            if($this->validation->validateInput('user', $post)) {
                $user = Search::lookForOr($this->userDAO->getUsers(), [
                    'pseudo' => $post->get('pseudo')
                ]);
                if(!$user) {
                    $this->alert->addError("Vos identifiants sont incorrects.");
                } else {
                    if($user[0]->getLevel() < parent::MEMBER_LEVEL) {
                        $this->alert->addError("Vous devez d'abord valider votre compte.");
                    } else {
                        if(!password_verify($post->get('password'), $user[0]->getPassword())) {
                            $this->alert->addError("Vos identifiants sont incorrects.");
                        } else {          
                            $this->userDAO->updateUser($user[0]->getId(), 'last_connection', $this->date);
                            $this->alert->addSuccess("Content de vous revoir.");
                            $this->session->set('id', $user[0]->getId());
                            $this->session->set('level', $user[0]->getLevel());
                            $this->session->set('pseudo', $user[0]->getPseudo());
                            ($this->checkAdmin())? header("Location: ".URL."admin") : header("Location: ".URL."profil");
                            exit;
                        }
                    }
                }
            }
        }
    }

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

}
