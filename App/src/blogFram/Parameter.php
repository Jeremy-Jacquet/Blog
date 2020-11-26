<?php

namespace App\src\blogFram;

/**
 * Parameter
 */
class Parameter
{    
    /**
     * @var array
     */
    private $parameter = [];
    
    /**
     * Construct
     *
     * @param  array $parameter[]
     * @return void
     */
    public function __construct($parameter)
    {
        $this->parameter = $parameter;
    }
    
    /**
     * Get parameter value
     *
     * @param  string $name
     * @return void|string parameter[$name]
     */
    public function get($name)
    {
        if(isset($this->parameter[$name])) {
            return $this->parameter[$name];
        }
    }
        
    /**
     * Set parameter value
     *
     * @param  string $name
     * @param  string|int $value
     * @return void
     */
    public function set($name, $value)
    {
        $this->parameter[$name] = $value;
    }
    
    /**
     * Get all parameters
     *
     * @return array  private $parameter[]
     */
    public function all()
    {
        return $this->parameter;
    }
    
    /**
     * Delete a parameter
     *
     * @param  array $names[]
     * @return void
     */
    public function delete($names = []) {
        foreach($names as $index => $name) {
            unset($this->parameter[$name]);
        }
    }

}
