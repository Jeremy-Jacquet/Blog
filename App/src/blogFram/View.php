<?php

namespace App\src\blogFram;

use App\src\blogFram\Session;
use App\src\blogFram\Alert;

/**
 * View
 */
class View
{    
    /**
     * @var Alert
     */
    private $alert;
    
    /**
     * session
     *
     * @var Session
     */
    private $session;
    
    public function __construct($session, $alert)
    {
        $this->alert = $alert;
        $this->session = $session;
    }
    
    public function render($controller, $admin, $template, $data = [])
    {
        $alerts = $this->alert->get();
        $this->alert->remove();
        $file = '../App/template/'.$controller.'/'.$template.'.php';
        $content  = $this->renderFile($file, $data);
        $view = $this->renderFile('../App/template/'.$controller.'/layout.php', [
            'content' => $content
        ]);
        echo $view;
    }
    

    private function renderFile($file, $data)
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
