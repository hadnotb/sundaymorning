<?php

namespace App\Framework;

class Tools
{
    public static function secureArray(array $array) : array {
        
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $array[$key] = self::secureArray($value);
            } else {
                $array[$key] = htmlspecialchars($value);
            }
        }
        return $array;
    }

}