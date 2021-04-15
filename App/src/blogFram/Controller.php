<?php
namespace App\src\blogFram;

use App\src\constraint\Validation;
use App\src\controller\LogController;
use App\src\controller\MainController;
use \DateTime;

abstract class Controller
{
    protected $get;
    protected $post;
    protected $file;
    protected $alert;
    protected $displayer;
    protected $view;
    protected $session;
    protected $logController;
    protected $mainController;
    protected $date;

    public function __construct($get, $post, $file)
    {
        $this->get = $get;
        $this->post = $post;
        $this->file = $file;
        $this->session = new Session($_SESSION);
        $this->alert = new Alert($this->session);
        $this->view = new View($this->session, $this->alert);
        $this->displayer = new Displayer($this->view);
        $this->validation = new Validation($this->alert);
        $this->logController = new LogController($this->session, $this->alert, $this->validation, $this->displayer);
        $this->mainController = new MainController($this->session, $this->alert, $this->validation);
        $this->setDate();
    }

    private function setDate()
    {
        $objDateTime = new DateTime('NOW');
        $this->date = $objDateTime->format('Y-m-d H:i:s');
    }

}