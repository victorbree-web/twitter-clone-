<?php


namespace App\Models;

use MF\Model\Model;

class Tweets extends Model{

    private $id;
    private $id_usuario;
    private $tweet;
    private $data;


    public function __get($atributo){
        return $this->$atributo;

    }

    public function __set($atributo , $valor){
        $this->$atributo = $valor;

    }


    public function salvar(){

        $query = 'insert into tweets (id_usuario, tweet) value (:id_usuario, :tweet)';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stnt->bindValue(':tweet', $this->__get('tweet'));
        $stnt->execute();

        return $this;

    }

    public function getAll(){

        $query= "
        select
            t.id, t.id_usuario, u.nome,DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data, t.tweet 
        from 
            tweets as t
            left join usuarios as u on (t.id_usuario = u.id)
        where
            t.id_usuario = :id_usuario
            or t.id_usuario in (select id_usuario_seguindo from usuarios_seguidores
            where id_usuario = :id_usuario)
        order by 
            t.data desc
        ";
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stnt->execute();

        return $stnt->fetchAll(\PDO::FETCH_ASSOC);




    }

     public function deletar(){

        $query = 'delete from tweets where id = :id';
        $stnt = $this->db->prepare($query);
        $stnt->bindValue(':id', $this->__get('id'));
        $stnt->execute();

        return true;


     }


}   

?>  