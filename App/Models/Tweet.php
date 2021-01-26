<?php

namespace App\Models;

use MF\Model\Model;

class Tweet extends Model{
    private $id, $id_usuario, $conteudo, $dia;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    #salvar
    public function salvar(){
        $query = 'INSERT INTO tweets(conteudo, id_usuario) value(:conteudo, :id_usuario)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':conteudo', $this->conteudo);
        $stmt->bindValue(':id_usuario', $this->id_usuario);
        $stmt->execute();
    }

    #listar

    public function getAll(){
        // $query = '
        // SELECT 
        //     t.id, u.nome, t.id_usuario, t.conteudo, DATE_FORMAT(t.dia, "%d/%m/%Y %H:%i") as dia 
        // FROM 
        //     tweets as t left join usuarios as u on(t.id_usuario = u.id) 
        // where id_usuario = :id_usuario ORDER BY id desc
        
        // ';
        $query = '
        SELECT
        t.id, u.nome, t.id_usuario, t.dia, t.conteudo 
        
        from tweets as 
        
        t left join usuarios as u on (t.id_usuario = u.id) 
        
        where id_usuario = :id_usuario OR id_usuario in (SELECT id_seguido FROM usuario_seguindo WHERE id_seguidor = :id_usuario) ORDER BY id desc
               
        ';

        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $_SESSION['id']);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);

    }

    #remover
    public function remove(){
        $query = 'DELETE FROM tweets where id = :id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        print $query;
    }

}