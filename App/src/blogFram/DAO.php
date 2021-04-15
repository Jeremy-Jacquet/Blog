<?php

namespace App\src\blogFram;

use PDO;
use Exception;

/**
 * DAO
 */
abstract class DAO
{
    
    /**
     * @var \PDO
     */
    private $connection;
    
    /**
     * check connection
     *
     * @return \PDO
     */
    protected function checkConnection()
    {
        if($this->connection === null) {
            return $this->getConnection();
        }
        return $this->connection;
    }
    
    /**
     * get connection
     *
     * @return \PDO
     */
    private function getConnection()
    {
        try{
            $this->connection = new PDO(DB_HOST, DB_USER, DB_PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connection;
        }
        catch(Exception $errorConnection)
        {
            die ('Erreur de connexion :'.$errorConnection->getMessage());
        }

    }
    
    protected function createQuery($sql, $parameters = null)
    {
        if($parameters) {
            $query = $this->checkConnection()->prepare($sql);
            $query->execute($parameters);
            return $query;
        }
        $query = $this->checkConnection()->query($sql);
        return $query;
    }
    
    /**
     * getSqlWhere
     *
     * @param  string $entity
     * @param  array $attributes
     * @return void
     */
    public function getSqlWhere($entity, $attributes)
    {
        $count = 0;
        $sql = '';
        $entityMark = $this->getEntityMark($entity);
        foreach($attributes as $attribute) {
            if($count === 0){
                if($attribute['value'] === null) {
                    $sql .= "WHERE ".$entityMark.$attribute['name']." IS NULL";
                } else {
                    $sql .= "WHERE ".$entityMark.$attribute['name']." = :".$attribute['name'];
                }
            } else {
                if($attribute['value'] === null) {
                    $sql .= " AND ".$entityMark.$attribute['name']." IS NULL";
                } else {
                    $sql .= " AND ".$entityMark.$attribute['name']." = :".$attribute['name'];
                }
            }
            $count ++;
        }
        return $sql;
    }
    
    public function getEntityMark($entity)
    {
        if($entity === 'article') {
            $entityMark = 'a.';
        } elseif($entity === 'category' OR $entity === 'comment') {
            $entityMark = 'c.';
        } elseif($entity === 'user') {
            $entityMark = 'u.';
        }
        return $entityMark;
    }

    public function getParameter($parameter)
    {
        if($parameter === 'integer') {
            $param = PDO::PARAM_INT;
        }
        elseif($parameter === 'string') {
            $param = PDO::PARAM_STR;
        }
        elseif($parameter === 'boolean') {
            $param = PDO::PARAM_BOOL;
        }
        return $param;
    }

}
