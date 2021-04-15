<?php

namespace App\src\DAO;

use App\src\blogFram\DAO;
use App\src\blogFram\Parameter;
use App\src\entity\User;
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
        $user->setLastConnection($row['last_connection']);
        $user->setSubscription($row['subscription']);
        $user->setFlag($row['flag']);
        $user->setBan($row['ban']);
        $user->setToken($row['token']);
        $user->setLevel($row['level']);
        return $user;
    }

    public function addUser($post) 
    {
        $this->checkConnection()->beginTransaction();
        $sql = "INSERT INTO `user` (`pseudo`, `password`, `email`, `filename`, `created_at`, `last_connection`, `subscription`, `level`, `flag`, `ban`, `token`) 
            VALUES (:pseudo, :password, :email, :filename, :created_at, :last_connection, :subscription, :level, :flag, :ban, :token)";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':pseudo', $post->get('pseudo'), PDO::PARAM_STR);
        $result->bindValue(':password', $post->get('password'), PDO::PARAM_STR);
        $result->bindValue(':email', $post->get('email'), PDO::PARAM_STR);
        $result->bindValue(':filename', 'tmp.'.$post->get('extension'), PDO::PARAM_STR);
        $result->bindValue(':created_at', $post->get('created_at'), PDO::PARAM_STR);
        $result->bindValue(':last_connection', $post->get('created_at'), PDO::PARAM_STR);
        $result->bindValue(':subscription', $post->get('subscription'), PDO::PARAM_INT);
        $result->bindValue(':level', $post->get('level'), PDO::PARAM_INT);
        $result->bindValue(':flag', 0, PDO::PARAM_INT);
        $result->bindValue(':ban', 0, PDO::PARAM_INT);
        $result->bindValue(':token', $post->get('token'), PDO::PARAM_STR);
        $result->execute();
        $newUserId = $this->checkConnection()->lastInsertId();
        $sql = "UPDATE `user` SET `filename` = :filename WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $newUserId, PDO::PARAM_INT);
        $result->bindValue(':filename', $newUserId.'.'.$post->get('extension'), PDO::PARAM_STR);
        $result->execute();
        $this->checkConnection()->commit();
        $result->closeCursor();
        return $newUserId;
    }

    public function updateUser($post)
    {
        if(!$this->checkUserId($post->get('id'))) {
            return false;
        }
        $sql = "UPDATE `user` SET `level` = :level, flag = :flag, ban = :ban WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->bindValue(':level', $post->get('level'), PDO::PARAM_INT);
        $result->bindValue(':flag', $post->get('flag'), PDO::PARAM_INT);
        $result->bindValue(':ban', $post->get('ban'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function deleteUser($post)
    {
        if(!$this->checkUserId($post->get('id'))) {
            return false;
        }
        $sql = 'DELETE FROM `user` WHERE id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor();
        return true;
    }

    public function getOneUser($userId)
    {
        if(!$this->checkUserId($userId)) {
            return false;
        }
        $sql = 'SELECT * FROM `user` WHERE id = :id';
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $userId, PDO::PARAM_INT);
        $result->execute();
        $row = $result->fetch();
        $user = $this->buildObject($row);
        $result->closeCursor();
        return $user;
    }

    public function getUsers($attributes, $limit = null, $start = null)
    {
        $sql = "SELECT * FROM user u ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('user', $attributes);
        }
        $sql .= " ORDER BY id DESC";
        if($limit !== null AND $start !== null) {
            $sql .= ' LIMIT '.$limit.' OFFSET '.$start;
        }
        if($attributes !== 'all') {
            $result = $this->checkConnection()->prepare($sql);
        } else {
            $result = $this->checkConnection()->query($sql);
        }
        if($attributes !== 'all') {
            foreach ($attributes as $attribute){
                $result->bindValue(':'.$attribute['name'], $attribute['value'], $this->getParameter($attribute['parameter']));
            }
        }
        $result->execute();
        $users = [];
        foreach ($result as $row){
            $users[] = $this->buildObject($row);
        }
        $result->closeCursor();
        return ($users)? $users : false;
    }

    public function updateUserAccount($post)
    {
        if(!$this->checkUserId($post->get('id'))) {
            return false;
        }
        $sql = 'UPDATE `user` SET ';
        if ($post->get('password')) {
            $sql .= 'password = :password WHERE id = :id';
            $result = $this->checkConnection()->prepare($sql);
            $result->bindValue(':password', $post->get('password'), PDO::PARAM_STR);
        }
        elseif ($post->get('email')) {
            $sql .= 'email = :email WHERE id = :id';
            $result = $this->checkConnection()->prepare($sql);
            $result->bindValue(':email', $post->get('email'), PDO::PARAM_STR);
        }
        elseif ($post->get('subscription') OR $post->get('subscription') === 0) {
            $sql .= 'subscription = :subscription WHERE id = :id';
            $result = $this->checkConnection()->prepare($sql);
            $result->bindValue(':subscription', $post->get('subscription'), PDO::PARAM_INT);
        }
        $result->bindValue(':id', $post->get('id'), PDO::PARAM_INT);
        $result->execute();
        $result->closeCursor(); 
        return true;
    }

    public function checkUserId($userId)
    {
        $sql = "SELECT COUNT(*) FROM `user` WHERE id = :id";
        $result = $this->checkConnection()->prepare($sql);
        $result->bindValue(':id', $userId, PDO::PARAM_INT);
        $result->execute();
        $count = $result->fetch();
        $result->closeCursor();
        return ($count[0] > 0)? true : false;
    }

    /**
     * count users
     *
     * @param  array $attributes
     * @return int
     */
    public function countUsers($attributes)
    {
        $sql = "SELECT COUNT(*) FROM user u ";
        if($attributes !== 'all') {
            $sql .= $this->getSqlWhere('user', $attributes);
            $result = $this->checkConnection()->prepare($sql);
        } else {
            $result = $this->checkConnection()->query($sql);
        }
        if($attributes !== 'all') {
            foreach ($attributes as $attribute){
                $result->bindValue(':'.$attribute['name'], $attribute['value'], $this->getParameter($attribute['parameter']));
            }
        }
        $result->execute();
        $count = $result->fetchColumn();
        $result->closeCursor();
        return $count;
    }
}
