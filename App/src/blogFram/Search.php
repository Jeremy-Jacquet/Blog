<?php

namespace App\src\blogFram;

/**
 * Search
 */
abstract class Search
{
    /**
     * Search an entity
     * 
     * Find if inside an array of entities,
     * an entity has one value or another inside an array of values
     *
     * @param  array $entities
     * @param  array $values
     * @return array [void]|[Objects]
     */
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
    
    /**
     * Search an entity
     * 
     * Find if inside an array of entities,
     * an entity has all wanted values inside an array of values
     *
     * @param  array [Objects]
     * @param  array $values
     * @return array [void]|[Objects]
     */
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
    
    /**
     * Search an entity
     *
     * find if inside an array of entities, 
     * an entity does not have a value or another inside an array of values
     * 
     * @param  array [Objects]
     * @param  array $values
     * @return array [void]|[Objects]
     */
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

    /**
     * Search an entity
     *
     * find if inside an array of entities, 
     * an entity does not have all values unwanted inside an array of values
     * 
     * @param  array [Objects]
     * @param  array $values
     * @return array [void]|[Objects]
     */
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
