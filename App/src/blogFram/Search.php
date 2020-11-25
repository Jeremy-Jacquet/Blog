<?php

namespace App\src\blogFram;

abstract class Search
{

    public static function lookForOr(array $entities, array $values) {
        $result = [];
        foreach($entities as $entity) {
            $count = 0;
            foreach($values as $value => $key) {
                $method = 'get'.ucfirst($value);
                if($entity->$method($value) == $key) {
                    if($count === 0) {
                        $count++;
                        $result[] = $entity;
                    }
                }
            }
        }
        return $result;
    }

    public static function lookForAnd(array $entities, array $values) {
        $result = [];
        foreach($entities as $entity) {
            $count = 0;
            foreach($values as $value => $key) {
                $method = 'get'.ucfirst($value);
                if($entity->$method($value) == $key) {
                    $count++;
                }
            }
            if(count($values) === $count) {
                $result[] = $entity;
            }
        }
        return $result;
    }

    public static function lookForNoOr(array $entities, array $values) {
        $result = [];
        foreach($entities as $entity) {
            $count = 0;
            foreach($values as $value => $key) {
                $method = 'get'.ucfirst($value);
                if($entity->$method($value) != $key) {
                    if($count === 0) {
                        $count++;
                        $result[] = $entity;
                    }
                }
            }
        }
        return $result;
    }

    public static function lookForNoAnd(array $entities, array $values) {
        $result = [];
        foreach($entities as $entity) {
            $count = 0;
            foreach($values as $value => $key) {
                $method = 'get'.ucfirst($value);
                if($entity->$method($value) != $key) {
                    $count++;
                }
            }
            if(count($values) === $count) {
                $result[] = $entity;
            }
        }
        return $result;
    }
    
}
