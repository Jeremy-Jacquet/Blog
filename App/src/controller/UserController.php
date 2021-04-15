<?php

namespace App\src\controller;

use App\src\blogFram\Parameter;
use App\src\blogFram\Session;
use App\src\blogFram\Alert;
use App\src\blogFram\Image;
use App\src\constraint\Validation;
use App\src\DAO\UserDAO;

class UserController
{
    private $session;
    private $alert;
    private $validation;
    private $userDAO;

    public function __construct($session, $alert, $validation)
    {
        $this->session = $session;
        $this->alert = $alert;
        $this->validation = $validation;
        $this->userDAO = new UserDAO;
    }

    public function addUser($post) {
        $newUserId = $this->userDAO->addUser($post);
        return $newUserId;
    }

    public function updateUser($post)
    {
        $isSuccess = $this->userDAO->updateUser($post);
        return $isSuccess;
    }

    public function updateUserAccount($post)
    {
        $isSuccess = $this->userDAO->updateUserAccount($post);
        return $isSuccess;
    }

    public function deleteUser($post)
    {
        $isSuccess = $this->userDAO->deleteUser($post);
        return $isSuccess;
    }

    public function getOneUser($userId)
    {
        $user = $this->userDAO->getOneUser($userId);
        return $user;
    }
    
    /**
     * getUsers
     *
     * @param  array|string $attributes (ex: 'all' or [['name' => status, 'value' => 1, 'parameter' => 'integer']])
     * @param  mixed $limit
     * @param  mixed $start
     * @return void
     */
    public function getUsers($attributes, $limit = null, $start = null)
    {
        $users = $this->userDAO->getUsers($attributes, $limit, $start);
        return $users;
    }

    public function checkIfUserExistsBy($attributes, $parameter)
    {
        if($attributes === 'pseudo') {
            $attributesUser = [
                ['name' => 'pseudo', 'value' => $parameter->get('pseudo'), 'parameter' => 'string']
            ];
        } elseif($attributes === 'email') { 
            $attributesUser = [
                ['name' => 'email', 'value' => $parameter->get('email'), 'parameter' => 'string']
            ];
        } elseif($attributes === 'emailAndToken') {
            $attributesUser = [
                ['name' => 'email', 'value' => $parameter->get('email'), 'parameter' => 'string'],
                ['name' => 'token', 'value' => $parameter->get('token'), 'parameter' => 'string']

            ];
        }
        $user = $user = $this->userController->getUsers($attributesUser);
        return ($user)? $user : false;
    }

    public function countUsers($attributes)
    {
        return $this->userDAO->countUsers($attributes);
    }

}
