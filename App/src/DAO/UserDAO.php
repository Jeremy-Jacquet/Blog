<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\blogFram\Parameter;
use App\src\entity\User;
use \DateTime;
use \PDO;

class UserDAO extends DAO
{
    private function buildObject($row)
    {
        $user = new User();
        $user->setId($row['id']);
        $user->setPseudo($row['pseudo']);
        $user->setPassword($row['password']);
        $user->setEmail($row['email']);
        $user->setFilename($row['filename']);
        $user->setCreatedAt($row['created_at']);
        $user->setLastConnexion($row['last_connexion']);
        $user->setNewsletter($row['newsletter']);
        $user->setFlag($row['flag']);
        $user->setBanned($row['banned']);
        $user->setRoleId($row['role_id']);
        $user->setToken($row['token']);
        return $user;
    }

    public function addUser(Parameter $post, $date, $token)
    {
        $sql = "INSERT INTO `user` (`id`, `pseudo`, `password`, `email`, `filename`, `created_at`, `last_connexion`, `newsletter`, `flag`, `banned`, `role_id`, `token`) 
            VALUES (:id, :pseudo, :password, :email, :filename, :created_at, :last_connexion, :newsletter, :flag, :banned, :role_id, :token)";
        $result = $this->checkConnexion()->prepare($sql);
        $result->bindValue(':id', NULL);
        $result->bindValue(':pseudo', $post->get('pseudo'), PDO::PARAM_STR);
        $result->bindValue(':password', password_hash($post->get('password'), PASSWORD_BCRYPT), PDO::PARAM_STR);
        $result->bindValue(':email', $post->get('email'), PDO::PARAM_STR);
        $result->bindValue(':filename', '1.png', PDO::PARAM_STR);
        $result->bindValue(':created_at', $date, PDO::PARAM_STR);
        $result->bindValue(':last_connexion', $date, PDO::PARAM_STR);
        $result->bindValue(':newsletter', 0, PDO::PARAM_INT);
        $result->bindValue(':flag', NULL, PDO::PARAM_INT);
        $result->bindValue(':banned', 0, PDO::PARAM_INT);
        $result->bindValue(':role_id', 1, PDO::PARAM_INT);
        $result->bindValue(':token', $token, PDO::PARAM_STR);
        $result->execute();
        $id = $this->checkConnexion()->lastInsertId();
        $result->closeCursor();
        
        return ($result)? $id : false;
    }

    public function getUser($id)
    {
        $sql = 'SELECT * FROM user WHERE id = :id';
        $result = $this->checkConnexion()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $user = $this->buildObject($row);
        $result->closeCursor();
        return $user;
    }

    public function getUsers()
    {
        $sql = 'SELECT * FROM user ORDER BY id DESC';
        $result = $this->checkConnexion()->query($sql);
        $result->execute();
        $users = [];
        foreach ($result as $row){
            $users[$row['id']] = $this->buildObject($row);
        }
        $result->closeCursor();
        return $users;
    }

    public function updateUser($id, $attribute, $value)
    {
        $sql = 'UPDATE user SET ';
        if ($attribute === 'pseudo') {
            $sql .= 'pseudo = :pseudo  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':pseudo', $value, PDO::PARAM_STR);
        }
        elseif ($attribute === 'password') {
            $sql .= 'password = :password  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':password', $value, PDO::PARAM_STR);
        }
        elseif ($attribute === 'email') {
            $sql .= 'email = :email  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':email', $value, PDO::PARAM_STR);
        }
        elseif ($attribute === 'filename') {
            $sql .= 'filename = :filename  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':filename', $value, PDO::PARAM_STR);
        }
        elseif ($attribute === 'last_connexion') {
            $sql .= 'last_connexion = :last_connexion  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':last_connexion', $value, PDO::PARAM_STR);
        }
        elseif ($attribute === 'newsletter') {
            $sql .= 'newsletter = :newsletter  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':newsletter', $value, PDO::PARAM_INT);
        }
        elseif ($attribute === 'flag') {
            $sql .= 'flag = :flag  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':flag', $value, PDO::PARAM_INT);
        }
        elseif ($attribute === 'banned') {
            $sql .= 'banned = :banned  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':banned', $value, PDO::PARAM_INT);
        }
        elseif ($attribute === 'role_id') {
            $sql .= 'role_id = :role_id  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':role_id', $value, PDO::PARAM_INT);
        }
        elseif ($attribute === 'token') {
            $sql .= 'token = :token  WHERE id = :id';
            $result = $this->checkConnexion()->prepare($sql);
            $result->bindValue(':token', $value, PDO::PARAM_STR);
        }
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor(); 
        return ($result)? true : false;
    }

    /*
    public function updateUser($id, $attribute, $value)
    {
        $result = $this->checkConnexion()->prepare("UPDATE user SET $attribute = :valueAttribute WHERE id = :id");
        $result->bindValue(':valueAttribute', $value);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor(); 
        return ($result)? true : false;
    }
    */

    public function deleteUser($id)
    {
        $sql = 'DELETE FROM user WHERE id = :id';
        $result = $this->checkConnexion()->prepare($sql);
        $result->bindValue(':id', $id, PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
    }

    public function existsUser($pseudo)
    {
        $sql = 'SELECT id FROM user WHERE pseudo = :pseudo';
        $result = $this->checkConnexion()->prepare($sql);
        $result->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $result->execute();
        $exists = $result->fetch();
        $result->closeCursor();
        return ($exists) ? true : false;
    }

}
