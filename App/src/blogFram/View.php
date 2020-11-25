<?php

namespace App\src\blogFram;

use App\src\blogFram\Session;

class View
{
    private $file;
    private $title;
    private $alert;
    private $session;

    public function __construct()
    {
        $this->alert = new Alert;
        $this->session = new Session($_SESSION);
    }

    public function render($controller, $template, $data = [])
    {
        $this->file = '../App/template/'.$controller.'/'.$template.'.php';
        $content  = $this->renderFile($this->file, $data);
        $view = $this->renderFile('../App/template/'.$controller.'/layout.php', [
            'title' => $this->title,
            'content' => $content,
            'alert' => $this->alert
        ]);
        echo $view;
    }

    public function renderFile($file, $data)
    {
        if(file_exists($file)){
            extract($data);
            ob_start();
            require $file;
            return ob_get_clean();
        }
        header('Location: index.php?route=notFound');
        exit;
    }
}
