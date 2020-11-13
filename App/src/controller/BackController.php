<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Search;

class BackController extends Controller
{
    private $controller = 'back';
    private $errors = [];

    public function logout()
    {
        $this->session->stop();
        $this->session->start();
        $this->session->set('logout', 'À bientôt');
        header("Location: ".URL."accueil");
    }

    public function profile()
    {
        if($this->checkLoggedIn()) {
            return $this->view->render($this->controller, 'profile');
        }
    }

    public function dashboard()
    {
        if($this->checkAdmin()) {
            $pendingArticles = Search::lookForOr($this->articleDAO->getArticles(),[
                'status' => PENDING_ARTICLE
            ]);
            $pendingComments = Search::lookForOr($this->commentDAO->getComments(),[
                'status' => PENDING_COMMENT
            ]);
            $users = $this->userDAO->getUsers();
            $admin = $this->userDAO->getUser($_SESSION['id']);
            return $this->view->render($this->controller, 'dashboard', [
                'admin' => $admin,
                'users' => $users,
                'pendingArticles' => $pendingArticles,
                'pendingComments' => $pendingComments
            ]);
        } else {
            $this->session->set('not_admin', 'Vous n\'avez pas le droit d\'accéder à cette page');
            header("Location: ".URL."accueil");
            exit;
        }
    }

}
