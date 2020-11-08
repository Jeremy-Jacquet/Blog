<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Mailer;

class BackController extends Controller
{
    private $controller = 'back';
    private $mailer;
    private $errors = [];

    public function register(Parameter $post = null)
    {
        if($post->get('submit')) {   
            $this->errors = $this->validation->validate($post, 'User'); 
            var_dump($this->errors);
            if (!$this->errors) {
                $existsUser = $this->userDAO->existsUser($post->get('pseudo'));
                if(!$existsUser) {
                    $dataUser = $this->userDAO->addUser($post);
                    if($dataUser) {
                        $this->sendMail($post, $dataUser);
                        header("location: ".URL."accueil");
                        exit;
                    } else {
                        $this->errors = ['request' => 'Il y a eu un problème avec votre inscription'];
                    }    
                } else {
                    $this->errors = ['pseudo' => 'Le pseudo existe déjà, veuillez en choisir un autre'];
                }
            }
        }
        return $this->view->render($this->controller, 'register', [
            'post' => $post,
            'errors' => $this->errors
        ]);
    }

    public function sendMail(Parameter $post, $dataUser)
    {
        $title = 'Email de confirmation';
        $body = $this->view->renderFile('../App/template/mail/mail_confirmation.php', [
            'title' => $title,
            'pseudo' => $post->get('pseudo'),
            'id' => $dataUser['id'],
            'token' => $dataUser['token']
            ]);
        $this->mailer = new Mailer();
        $this->mailer->setMail($title, FROM_EMAIL, FROM_USERNAME, $post->get('email'), $body);
        $this->mailer->sendMail();
    }

    public function confirmRegister($id, $token)
    {
        $validToken = $this->userDAO->getUser($id)->getToken();
        if($token === $validToken) {
            if($this->userDAO->updateUser($id, 'role_id', ROLE_MEMBER)) {
                header("location: ".URL."accueil");
                exit;
            }
        }
    }

}
