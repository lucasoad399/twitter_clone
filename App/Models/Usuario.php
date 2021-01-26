<?php

namespace App\Models;

use MF\Model\Model;

class Usuario extends Model{
    private $id, $nome, $email, $senha;

    public function __get($atributo){
        return $this->$atributo;
    }

    public function __set($atributo, $valor){
        $this->$atributo = $valor;
    }

    #salvar;

    public function salvar(){
        $query = 'INSERT INTO usuarios(nome, email, senha) value(:nome, :email, :senha)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':senha', $this->senha);
        $stmt->execute();

        return $this;
    }
    #validar;

    public function validarCadastro(){
        $teste = true;
        if(strlen($this->nome)<=3)  $teste = false;
        if(strlen($this->email)<=3) $teste = false;
        if(strlen($this->senha)<=3) $teste = false;
        if(count($this->getUsuarioPorEmail())>0) $teste = false;
        return $teste;
    }
    #recuperar por email

    public function getUsuarioPorEmail(){
        $query = 'SELECT nome, email from usuarios where email = :email';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':email', $this->email);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function autenticar(){
        $query = 'SELECT id, nome from usuarios where email = :email and senha = :senha';
        $stmt = $this->db->prepare($query);
        $stmt->execute([
            ':email'    =>      $this->email,
            ':senha'    =>      $this->senha 
        ]);
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if(!empty($usuario)){
            $this->id = $usuario['id'];
            $this->nome = $usuario['nome'];
        }
    }

    public function getAll(){
        $query = 'SELECT id, nome, email FROM usuarios where nome like :nomePesquisado AND NOT id=:id';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':nomePesquisado', "%$this->nome%");
        $stmt->bindValue(':id', $this->id);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

}

