<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class IndexController extends Action {

	public function index() {
		$this->view->login = isset($_GET['login']) ? $_GET['login'] : '';
		$this->render('index');
	}

	public function inscreverse() {

		$this->view->user= array(
			'nome' => '',
			'email' => '',
			'senha' => ''
		);

		$this->view->errocadastro = false;
		$this->render('inscreverse');
	}
	public function cadastro() {

	//	$this->render('cadastro');

	//	print_r($_POST);

		$usuario = Container::getModel('usuario');

		$usuario->__set('nome', $_POST['nome']);
		$usuario->__set('email', $_POST['email']);
		$usuario->__set('senha', md5($_POST['senha']));

		if($usuario->validar() && count($usuario->getUser()) == 0 ){
		$usuario->salvar();

		} else{

			$this->view->user= array(
				'nome' => $_POST['nome'],
				'email' => $_POST['email'],
				'senha' => $_POST['senha']
			);
			$this->view->errocadastro = true;
			$this->render('inscreverse');
		}

		$this->render('cadastro');
	}

}


?>