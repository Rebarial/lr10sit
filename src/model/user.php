<?php

namespace model;

use PDO;

class user
{
    private $connect;

    public function __construct()
    {
        $this->connect = new PDO("mysql:host=localhost;dbname=lr10", "lr10user", "lr10parol");
    }
    public function isRegistred($login)
    {
        $sql = 'select login from users where login =' . "'" . $login . "'";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        if ($stmt->fetchAll())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function HashPass($password)
    {
        return md5($password);
    }

    public function Auntetification($login, $password)
    {
        $sql = 'select hash from users where login =' . "'" .  $login . "'";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $hash = $stmt->fetchAll()[0][0];
        $UserHash = $this->HashPass($password);
        if ($hash == $UserHash){
            return true;
        }
        else
        {
            return false;
        }
    }

    public function Add($login, $pass){
        $hash = $this->HashPass($pass);
        $sql = 'insert into users (login, hash) values (' . "'" . $login . "'" . ', ' . "'" . $hash . "'" . ')';
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam('login', $login);
        $stmt->bindParam('hash', $hash);
        $stmt->execute();
    }

    public function Delete($login){
        $sql = 'Delete from users where login = ' . "'" . $login . "'";
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam('login', $login);
        $stmt->bindParam('hash', $hash);
        $stmt->execute();
    }
    #public function





}