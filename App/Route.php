<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['inscreverse'] = array(
			'route' => '/inscreverse',
			'controller' => 'indexController',
			'action' => 'inscreverse'
		);

		$routes['cadastro'] = array(
			'route' => '/cadastro',
			'controller' => 'indexController',
			'action' => 'cadastro'
		);
		
		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		
		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AppController',
			'action' => 'sair'
		);

		
		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'timeline'
		);

		$routes['tweets'] = array(
			'route' => '/tweets',
			'controller' => 'AppController',
			'action' => 'tweets'
		);

		$routes['quemSeguir'] = array(
			'route' => '/quemSeguir',
			'controller' => 'AppController',
			'action' => 'quemSeguir'
		);

		$routes['acao'] = array(
			'route' => '/acao',
			'controller' => 'AppController',
			'action' => 'acao'
		);

		$routes['remover'] = array(
			'route' => '/remover',
			'controller' => 'AppController',
			'action' => 'remover'
		);


		$this->setRoutes($routes);
	}

}

?>