<?php

namespace App\src\controller;

use App\src\blogFram\Search;

class BackController extends Controller
{
    private $controller = 'back';

    public function logout()
    {
        $this->session->stop();
        $this->session->start();
        $this->alert->addSuccess('A bientôt');
        header("Location: ".URL."accueil");
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
            $this->alert->addError('Vous n\'avez pas le droit d\'accéder à cette page');
        }
        header("Location: ".URL."accueil");
        exit;
    }
}
