<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AuthController extends Action {
    public function autenticar(){
        echo "<pre>";
        print_r($_POST);
        echo "</pre>";

        $usuario = Container::getModel('usuario');
        $usuario->email = $_POST['email'];
        $usuario->senha = md5($_POST['senha']);
        
        $usuario->autenticar();

        echo "<pre>";
        print_r($usuario);
        echo "</pre>";

        if($usuario->id != '' && $usuario->nome != ''){
            #echo 'Usuario encontrado';
            session_start();
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nome']=$usuario->nome;
            header('location:/timeline');
        }else{
            #echo 'usuario não encontrado';
            header('location:/?login=erro');
        }
    }

    public function sair(){
        session_start();
        session_destroy();
        header('location:/');
    }

}