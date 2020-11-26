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
     * Check if connection already exists
     *
     * @return \PDO $connection
     */
    protected function checkConnection()
    {
        if($this->connection === null) {
            return $this->getConnection();
        }
        return $this->connection;
    }
    
    /**
     * Get connection
     *
     * @return \PDO $connection
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
    
    /**
     * Create query / Create prepare
     *
     * @param  mixed $sql
     * @param  mixed $parameters
     * @return mixed $result
     */
    protected function createQuery($sql, $parameters = null)
    {
        if($parameters) {
            $result = $this->checkConnection()->prepare($sql);
            $result->execute($parameters);
            return $result;
        }
        $result = $this->checkConnection()->query($sql);
        return $result;
    }

}