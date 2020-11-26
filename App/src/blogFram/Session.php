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
     * Construct
     *
     * @param  array $session ($_SESSION)
     * @return void
     */
    public function __construct($session)
    {
        $this->session = $session;
    }
    
    /**
     * Set $_SESSION[$name] = $value
     *
     * @param  string $name
     * @param  string $value
     * @return void
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    /**
     * Get value of $_SESSION[$name] 
     *
     * @param  string $name
     * @return $_SESSION[$name]
     */
    public function get($name)
    {
        if(isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
    }
    
    /**
     * Show and remove value of $_SESSION[$name]
     *
     * @param  string $name
     * @return void|string $value
     */
    public function show($name)
    {
        if(isset($_SESSION[$name])) {
            $value = $this->get($name);
            $this->remove($name);
            return $value;
        }
    }
    
    /**
     * Remove value of $_SESSION[$name]
     *
     * @param  string $name
     * @return void
     */
    public function remove($name)
    {
        unset($_SESSION[$name]);
    }
    
    /**
     * Start the session
     *
     * @return void
     */
    public function start()
    {
        session_start();
    }
    
    /**
     * Stop the session
     *
     * @return void
     */
    public function stop()
    {
        $_SESSION = [];
        unset($_SESSION);
        session_destroy();
    }

}