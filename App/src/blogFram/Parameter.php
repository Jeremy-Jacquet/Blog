<?php

namespace App\src\blogFram;

class Parameter
{    
    private $parameter = [];
  
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }

    public function get($name)
    {
        if(!isset($this->parameter[$name])) {
            return false;
        }
        return $this->parameter[$name];
    }

    public function set($name, $value)
    {
        $this->parameter[$name] = $value;
        return $this;
    }

    public function all()
    {
        return $this->parameter;
    }
    
    public function delete($names = []) 
    {
        foreach($names as $index => $name) {
            unset($this->parameter[$name]);
        }
    }

}
