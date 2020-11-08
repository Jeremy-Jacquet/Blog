<?php

namespace App\src\blogFram;

use PDO;
use Exception;

abstract class DAO
{

    private $connexion;

    protected function checkConnexion()
    {
        if($this->connexion === null) {
            return $this->getConnexion();
        }
        return $this->connexion;
    }

    private function getConnexion()
    {
        try{
            $this->connexion = new PDO(DB_HOST, DB_USER, DB_PASS);
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->connexion;
        }
        catch(Exception $errorConnexion)
        {
            die ('Erreur de connection :'.$errorConnexion->getMessage());
        }

    }

    protected function createQuery($sql, $parameters = null)
    {
        if($parameters) {
            $result = $this->checkConnexion()->prepare($sql);
            $result->execute($parameters);
            return $result;
        }
        $result = $this->checkConnexion()->query($sql);
        return $result;
    }

}