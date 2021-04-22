<?php


namespace App\Models;

use MF\Model\Model;

class Usuario extends Model{

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $validar;


    public function __get($atributo){
    return $this->$atributo;

    }

    public function __set($atributo , $valor){
        $this->$atributo = $valor;

    }


    public function salvar(){

        $query = 'insert into usuarios (nome, email, senha) value (:nome, :email, :senha)';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':nome', $this->__get('nome'));
        $stnt->bindValue(':email', $this->__get('email'));
        $stnt->bindValue(':senha', $this->__get('senha'));
        $stnt->execute();

        return $this;

    }

    public function validar(){

        $validar = true;

        if(strlen($this->__get('nome')) < 3){

            $validar = false;
        }

        if(strlen($this->__get('email')) < 3){

            $validar = false;
        }

        if(strlen($this->__get('senha')) < 3) {

            $validar = false;
        }

        return $validar;

    }

    public function getUser(){

        $query = 'select nome, email from usuarios where :email = email';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':email', $this->__get('email'));
        $stnt->execute();

        return $stnt->fetchAll(\PDO::FETCH_ASSOC);



    }

    public function autenticar(){

        $query = 'select id, nome, email from usuarios where email = :email and senha = :senha';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->__get('email'));
        $stmt->bindValue(':senha', $this->__get('senha'));
        $stmt->execute();

        $retorno = $stmt->fetch(\PDO::FETCH_ASSOC);

    if(isset($retorno)){
        if($retorno['id'] != "" && $retorno['nome'] != ""){

            $this->__set('id', $retorno['id']);
            $this->__set('nome', $retorno['nome']);
        }
    }

        return $this;

    }


    public function getAll(){

     $query = '
        select
            u.id, u.nome, u.email,
            (
                select 
                    count(*) 
                from 
                    usuarios_seguidores as us 
        where
            us.id_usuario = :id_usuario and us.id_usuario_seguindo = u.id)
        as seguindo_sn    
        from 
            usuarios as u
        where 
            u.nome like :nome and u.id != :id_usuario';
     $stmt = $this->db->prepare($query);
     $stmt->bindValue(':nome', '%'. $this->__get('nome') .'%');
     $stmt->bindValue(':id_usuario',$this->__get('id'));
     $stmt->execute(); 

     return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    public function seguir($usuario){

        $query = 'insert into usuarios_seguidores(id_usuario, id_usuario_seguindo) value (:id_usuario, :id_usuario_seguindo)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario_seguindo', $usuario);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute(); 

        return true;


        
    }
    
    public function deixarSeguir($usuario){

        $query = 'delete from usuarios_seguidores where id_usuario = :id_usuario and id_usuario_seguindo = :id_usuario_seguindo';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario_seguindo', $usuario);
        $stmt->bindValue(':id_usuario', $this->__get('id'));
        $stmt->execute(); 
        return true;


        
    }

    public function getNome(){
        $query = 'select nome from usuarios where id = :id_usuario';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':id_usuario', $this->__get('id'));
        $stnt->execute();

        return  $stnt->fetch(\PDO::FETCH_ASSOC);

    }

    public function getTweets(){
        $query = 'select count(*) as total_tweets from tweets where id_usuario = :id_usuario';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':id_usuario', $this->__get('id'));
        $stnt->execute();

        return $stnt->fetch(\PDO::FETCH_ASSOC);

    }

    public function getTotalSeguindo(){
        $query = 'select count(*) as total_seguindo from usuarios_seguidores where id_usuario = :id_usuario';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':id_usuario', $this->__get('id'));
        $stnt->execute();

        return $stnt->fetch(\PDO::FETCH_ASSOC);

    }

    public function getTotalSeguidores(){
        $query = 'select count(*) as total_seguidores from usuarios_seguidores where id_usuario_seguindo = :id_usuario';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':id_usuario', $this->__get('id'));
        $stnt->execute();

        return $stnt->fetch(\PDO::FETCH_ASSOC);

    }


    





}





?>