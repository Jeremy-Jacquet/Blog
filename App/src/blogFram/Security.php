<?php

namespace App\src\blogFram;

/**
 * Security
 */
class Security
{    
    /**
     * Secure data (trim + stripslashes + htmlspecialchars)
     *
     * @param  string $data
     * @return string $secureData
     */
    public function secureData($data) 
    {
        $secureData = trim($data);
        $secureData = stripslashes($secureData);
        $secureData = htmlspecialchars($secureData);
        return $secureData;
    }
    
    /**
     * Secure array[string] (trim + stripslashes + htmlspecialchars)
     *
     * @param  array $array[string]
     * @return array $array[string]
     */
    public function secureArray($array) 
    {
        foreach($array as $key => $value) {
            $array[$key] = $this->secureData($value);
        }
        return $array;
    }
}