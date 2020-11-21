<?php

namespace App\src\blogFram;

class Security
{
    public function secureData($data) 
    {
        $secureData = trim($data);
        $secureData = stripslashes($secureData);
        $secureData = htmlspecialchars($secureData);
        return $secureData;
    }

    public function secureArray($array = null) 
    {
        foreach($array as $key => $value) {
            $array[$key] = $this->secureData($value);
        }
        return $array;
    }
}