<?php

namespace App\src\blogFram;

/**
 * Session
 */
class Session
{ 
    /**
     * @var array
     */
    private $session = [];
    
    /**
     * construct Session
     *
     * @param  array $session
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;
        return $this;
    }

    /**
     * get value of $_SESSION[$name] 
     *
     * @param  string $name
     * @return array|false
     */
    public function get($name)
    {
        if(!isset($_SESSION[$name])) {
            return false;
        }        
        return $_SESSION[$name];
    }
 
    /**
     * get alerts
     *
     * @param  string $type         ex: info,success,error
     * @param  string $section      ex: main, comment
     * @return array|false
     */
    public function getAlerts($type = null, $section = null)
    {
        if(!isset($_SESSION['alert'])) {
            return false;
        }
        if($type === null) {
            $result = (isset($_SESSION['alert']))? $_SESSION['alert'] : false;
        } elseif($section === null) {
            $result = (isset($_SESSION['alert'][$type]))? $_SESSION['alert'][$type] : false;
        } else {
            $result = (isset($_SESSION['alert'][$type][$section]))? $_SESSION['alert'][$type][$section] : false;
        }
        return $result;
    }

    public function setUserSession($user)
    {
        $this
            ->set('id', $user[0]->getId())
            ->set('level', $user[0]->getLevel())
            ->set('pseudo', $user[0]->getPseudo());
        return $this;
    }

    /**
     * set $_SESSION[$name] = $value
     *
     * @param  string $name
     * @param  string $value
     * @return Session
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
        return $this;
    }
    
    /**
     * set alert
     *
     * @param  string $type         ex: info,success,error
     * @param  string $section      ex: main, comment
     * @param  string $alert        ex: <p class="...
     * @return Session
     */
    public function setAlert($type, $section, $alert)
    {
        $_SESSION['alert'][$type][$section][] = $alert;
        return $this;
    }
    
    /**
     * remove $_SESSION[$name]
     *
     * @param  string $name
     * @return Session
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
        return $this;
    }
    
    /**
     * start the session
     *
     * @return Session
     */
    public function start()
    {
        session_start();
        return $this;
    }
    
    /**
     * stop the session
     * 
     * @return Session
     */
    public function stop()
    {
        $_SESSION = [];
        unset($_SESSION);
        session_destroy();
        return $this;
    }

}
