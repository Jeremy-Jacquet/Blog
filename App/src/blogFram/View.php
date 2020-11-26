<?php

namespace App\src\blogFram;

use App\src\blogFram\Session;

/**
 * View
 */
class View
{    
    /**
     * @var string
     */
    private $file;

    /**
     * @var string
     */
    private $title;

    /**
     * @var Alert
     */
    private $alert;

    /**
     * @var Session
     */
    private $session;
    
    /**
     * Construct View
     *
     * @return void
     */
    public function __construct()
    {
        $this->alert = new Alert;
        $this->session = new Session($_SESSION);
    }
    
    /**
     * Render view
     *
     * @param  string $controller
     * @param  string $template
     * @param  array $data[$vars] ($vars will be extract in renderFile())
     * @return mixed $view
     */
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
    
    /**
     * Render file for view
     *
     * @param  string $file (path to know if exists)
     * @param  array $data[$vars] (will be extract)
     * @return mixed ob_get_clean
     */
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
