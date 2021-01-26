<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    public function validaAutenticacao(){
        session_start();
        if(empty($_SESSION['id'])) header('Location: /?login=erro');
    }

    public function timeline(){
        $this->validaAutenticacao();
        
        
        $tweet = Container::getModel('tweet');

        $tweets = $tweet->getAll();
        $this->view->nome = $_SESSION['nome'];
        $this->view->tweets = $tweets;
        $this->view->totalTweets = $this->contaTweets();
        // print '<br><br><pre>';
        // print_r($tweets);
        // print '</pre>';
        
        $this->view->contaSeguindo =  $this->contaSeguindo();
        $this->view->contaSeguidores =  $this->contaSeguidores();
        
        $this->render('timeline');
    }

    public function quemSeguir(){
        $this->validaAutenticacao();
        

        $nomePesquisado = isset($_GET['nomePesquisado'])? $_GET['nomePesquisado'] : '';

        $usuario = Container::getModel('Usuario');
        $this->view->nome = $_SESSION['nome'];
        
        $usuario->nome = $nomePesquisado;
        $usuario->id = $_SESSION['id'];

        $usuarios = $usuario->getAll();
        
        $this->view->usuarios = $usuarios;
        $this->view->totalTweets = $this->contaTweets();


        #####
        $seguindo = Container::getModel('UsuarioSeguindo');
        $seguindo->id_seguidor = $_SESSION['id'];
        $this->view->seguindo = $seguindo;
        #####
        $this->view->totalTweets = $this->contaTweets();
        $this->view->contaSeguindo =  $this->contaSeguindo();
        $this->view->contaSeguidores =  $this->contaSeguidores();
        $this->render('quemSeguir');
    }

    public function tweet(){
        $this->validaAutenticacao();
        if(empty($_POST['tweet'])) header('location: /timeline');

        $tweet = Container::getModel('Tweet');

        $tweet->conteudo = $_POST['tweet'];
        $tweet->id_usuario = $_SESSION['id'];
        $tweet->salvar();

        header('location: /timeline');

    }
    public function remover(){
        $this->validaAutenticacao();
        print '<pre>';
        print_r($_POST);
        print'</pre>';
        echo 'sessao é '. $_SESSION['id'];

        $tweet = Container::getModel('Tweet');
        $tweet->id = $_POST['id'];
         print '<pre>';
        print_r($tweet);
        print'</pre>';
        if($_POST['id_usuario'] == $_SESSION['id'] ){
            $tweet->remove();
        } 
        header('location: /timeline');
    }

   
    public function contaTweets(){
        $tweet = Container::getModel('tweet');
        $tweets = $tweet->getAll();
        return count($tweets);
    }

    public function contaSeguindo(){
        $seguindo = Container::getModel('UsuarioSeguindo');
        $seguindo->id_seguidor = $_SESSION['id'];
        return $seguindo->totalSeguindo();
    }

    public function contaSeguidores(){
        $seguindo = Container::getModel('UsuarioSeguindo');
        $seguindo->id_seguido = $_SESSION['id'];
        return $seguindo->totalSeguidores();
    }

    public function acao(){
        $this->validaAutenticacao();


        $dadosAcao = array(
            $_SESSION['id'],
            $_GET['acao'],
            $_GET['id']
        );
        echo '<pre>';
        \print_r($dadosAcao);
        echo '</pre>';

        $usuario_seguindo = Container::getModel('UsuarioSeguindo');
        $usuario_seguindo->id_seguidor = $dadosAcao[0];
        $usuario_seguindo->id_seguido = $dadosAcao[2];
        if($dadosAcao[1]==='seguir' AND $usuario_seguindo->testaSeguindo() == false){
            $usuario_seguindo->seguir();    
        }else if($dadosAcao[1]==='deixar'){
            $usuario_seguindo->deixar();
        }

        header('location:/quem_seguir');
        
        

    }

    
}