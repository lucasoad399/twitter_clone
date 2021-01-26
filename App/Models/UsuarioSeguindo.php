<?php

namespace App\Models;

use MF\Model\Model;

class UsuarioSeguindo extends Model{
    private $id, $id_seguidor,$id_seguido;

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    public function __get($atributo){
        return $this->$atributo;
    }
    /*
SELECT COUNT(*) FROM usuario_seguindo WHERE id_seguidor = 1 AND id_seguido = 2
*/
    public function testaSeguindo(){
        $query = '
            SELECT
                COUNT(*) 
            FROM 
                usuario_seguindo 
            WHERE 
                id_seguidor = :id_seguidor AND id_seguido = :id_seguido;';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_seguidor', $this->id_seguidor);
        $stmt->bindValue(':id_seguido', $this->id_seguido);
        $stmt->execute();
        $count = $stmt->fetch(\PDO::FETCH_NUM)[0];
        if($count>0) return true; return false;
    }

    public function seguir(){
        $query = 'INSERT INTO usuario_seguindo(id_seguidor, id_seguido) VALUE(:id_seguidor,:id_seguido)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_seguidor', $this->id_seguidor);
        $stmt->bindValue(':id_seguido', $this->id_seguido);
        $stmt->execute();
    }

    public function deixar(){
        $query = '
            DELETE FROM 
                usuario_seguindo 
            WHERE 
                id_seguidor = :id_seguidor 
            AND 
                id_seguido = :id_seguido';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_seguidor', $this->id_seguidor);
        $stmt->bindValue(':id_seguido', $this->id_seguido);
        $stmt->execute();
    }

    public function totalSeguindo(){
        $query = "SELECT COUNT(*) FROM usuario_seguindo WHERE id_seguidor = :id_seguidor";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_seguidor', $this->id_seguidor);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_NUM)[0]; 
    }
    public function totalSeguidores(){
        $query = "SELECT COUNT(*) FROM usuario_seguindo WHERE id_seguido = :id_seguido";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_seguido', $this->id_seguido);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_NUM)[0]; 
    }

}