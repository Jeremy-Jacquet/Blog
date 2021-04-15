<?php

namespace App\src\blogFram;

/**
 * Alert
 */
class Alert
{    
    /**
     * 
     * @var Session
     */
    private $session;   
    
    /**
     * construct Alert
     *
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;
        return $this;
    }
    
    /**
     * get alerts
     *
     * @param string $type
     * @param string $section
     * @return array|false
     */
    public function get($type = null, $section = null)
    {
        $alerts = $this->session->getAlerts($type, $section);
        return $alerts;
    }
    
    /**
     * set $_SESSION['alert']
     *
     * @param  string $type         ex: 'success', 'error', 'info'
     * @param  string $intensity    ex: 'low', 'normal', 'high'
     * @param  string $section      ex: 'main', 'comment'
     * @param  string $message
     * @return Alert
     */
    public function set($type, $intensity, $section, $message)
    {
        $alert = $this->getMessage($type, $intensity, $message);
        $this->session->setAlert($type, $section, $alert);
        return $this;
    }
    
    /**
     * get alert message
     *
     * @param  string $type         ex: 'success', 'error', 'info'
     * @param  string $intensity    ex: 'low', 'normal', 'high'
     * @param  string $message
     * @return string
     */
    public function getMessage($type, $intensity, $message)
    {
        $message = "<p class=\"text-center ".$type."-".$intensity." m-auto\">$message</p>";
        return $message;
    }

    /**
     * remove $_SESSION['alert']
     *
     * @return void
     */
    public function remove() {
        $this->session->remove('alert');
    }

}
