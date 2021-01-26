<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
		$this->view->login = isset($_GET['login'])? $_GET['login']: '';
		$this->render('index');
	}

	public function inscreverse() {
		$this->view->erroCadastro=false;
		$this->render('inscreverse');
	}

	public function registrar(){
		// echo '<pre>';
		// print_r($_POST);
		// echo '</pre>';

		$usuario = Container::getModel('Usuario');
		$usuario->nome = $_POST['nome'];
		$usuario->email = $_POST['email'];
		$usuario->senha = md5($_POST['senha']);

		// echo '<pre>';
		// print_r($usuario);
		// echo '</pre>';
		if($usuario->validarCadastro()){
			// echo 'Usuário válido para cadastro';
			$usuario->salvar();
			$this->render('cadastro');
		}else{
			// echo 'Usuario inválido para cadastro';
			$this->view->erroCadastro = true;
			$this->render('inscreverse');
			
		}
		
	}

}


?>