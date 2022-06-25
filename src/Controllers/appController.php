<?php

namespace Controllers;
require_once __DIR__ . '/../model/user.php';

use model\user;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class appController
{

    private $userM;
    private $view;
    public function __construct()
    {
        $this->UserM = new user();
        $this->view = new Environment(new FilesystemLoader(dirname(__DIR__) . "/View"));
    }

    public function start(){

        if ($_SERVER['REQUEST_URI'] == '/profil')
        {
            echo $this->view->render('profile.html.twig', ['user' => $_COOKIE["user"]]);
            unset($_COOKIE["user"]);
        }
        elseif ($_SERVER['REQUEST_URI'] == '/deleteUser')
        {
            $this->UserM->delete($_COOKIE["user"]);
            setcookie("user", "");
            unset($_COOKIE["user"]);
            header('Location: /index');
        }
        elseif ($_SERVER['REQUEST_URI'] == '/unLogin')
        {
            setcookie("user", "");
            unset($_COOKIE["user"]);
            header('Location: /index');
        }
        elseif($_COOKIE["user"] != ""){
            header('Location: /profil');
        }
        elseif ($_SERVER['REQUEST_URI'] == '/signIn')
        {
            $login = $_POST['login'];
            $password = $_POST['pass'];
            if ($login != "" && $password != ""){
                if ($this->UserM->isRegistred($login) && $this->UserM->Auntetification($login, $password)){
                    setcookie('user', $login);
                    header('Location: /profil');
                }
                else
                {
                    echo $this->view->render('signIn.html.twig');
                    echo ("Неверный логин или пароль!");
                }

            }
            else {
                echo $this->view->render('signIn.html.twig');
            }
        }
        elseif ($_SERVER['REQUEST_URI'] == '/signUp')
        {
            $login = $_POST['login'];
            $password = $_POST['pass'];
            if ($login != "" && $password != ""){
                if ($this->UserM->isRegistred($login)){
                    echo $this->view->render('signUp.html.twig');
                    echo ("Логин или пароль уже существует, используйте другой или войдите в аккаунт!");
                }
                else
                {
                    $this->UserM->Add($login, $password);
                    echo $this->view->render('signUp.html.twig');
                    echo ("Аккаунт зарегистрирован!");
                }

            }
            else {
                echo $this->view->render('signUp.html.twig');
            }
        }
        elseif($_SERVER['REQUEST_URI'] == '/index')
        {
            echo $this->view->render('index.html.twig');
        }
        else
        {
            header('Location: /index');
        }



    }

}