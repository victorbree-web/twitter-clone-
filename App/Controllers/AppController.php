<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

    class AppController extends Action{

        public function timeline(){

 
            $this->validaAUTH();

            $user1 = Container::getModel('Usuario');

                $tweet = Container::getModel('tweets');
                $tweet->__set('id_usuario', $_SESSION['id']);

                $tweets = $tweet->getAll();

                $this->view->tweets = $tweets ;


                
                $user1 = Container::getModel('Usuario');
                $user1->__set('id', $_SESSION['id']);


                $this->view->nome = $user1->getNome();
                $this->view->postagem = $user1->getTweets();
                $this->view->seguindo = $user1->getTotalSeguindo();
                $this->view->seguidores = $user1->getTotalSeguidores();


               $this->render('timeline'); 
        }

        public function sair(){

            session_start();
            session_destroy();
            header('Location: /');

        }


        public function tweets(){


            $this->validaAUTH();

                $tweet = Container::getModel('tweets');

                $tweet->__set('id_usuario', $_SESSION['id']);
                $tweet->__set('tweet', $_POST['tweet']);
    
                $tweet->salvar();

                header('location: /timeline');

             }



        

        public function validaAUTH(){


            session_start();

            if(!isset($_SESSION['id']) || $_SESSION['id'] == '' && !isset($_SESSION['nome']) || $_SESSION['nome'] == ''){
    
                header('Location: /?login=erro');
            }


        }

        public function quemSeguir(){

            $this->validaAUTH();

            

            $pesquisa = isset($_GET['quemSeguir']) ? $_GET['quemSeguir'] : '';

            $user = array();

            if($pesquisa != ''){

                $usuario = Container::getModel('usuario');

                $usuario->__set('nome', $pesquisa);
                $usuario->__set('id', $_SESSION['id']);

                $user = $usuario->getAll();


            }

            $this->view->user = $user;


            $this->render('quemSeguir');


        }

        public function acao(){

            $this->validaAUTH();

            $acao = isset($_GET['acao']) ?  $_GET['acao']  : '';
            $idSeguindo = isset($_GET['id_usuario']) ?  $_GET['id_usuario']  : '';

            $usuario = Container::getModel('usuario');
            $usuario->__set('id', $_SESSION['id']);

            if($acao == 'Seguir'){



                $usuario->seguir($idSeguindo);

                header('location: /quemSeguir');
   

            }else if ($acao == 'deixarSeguir')

                $usuario->deixarSeguir($idSeguindo);

                header('location: /quemSeguir');


        }


        public function remover(){


            $this->validaAUTH();

            $tweet = Container::getModel('tweets');
            $tweet->__set('id',$_GET['id']);

            $tweet->deletar();

            header('location: /timeline');
            

        }
           
    }    


?>