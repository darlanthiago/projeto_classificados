<?php

class Usuario{

    private $nome;
    private $email;
    private $senha;
    private $telefone;


    public function __get($attr)
    {
        return $this->$attr;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }

    public function cadastrar($n, $e, $s, $t){

        global $pdo;

        $sql = "SELECT id FROM usuario WHERE email = :email";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(":email", $e);
        $sql->execute();

        if($sql->rowCount() == 0){

            $sql = "INSERT INTO usuario(nome, email, senha, telefone) VALUES(:nome, :email, :senha, :telefone)";
            $sql = $pdo->prepare($sql);
            $sql->bindValue(':nome', $n);
            $sql->bindValue(':email', $e);
            $sql->bindValue(':senha', md5($s));
            $sql->bindValue(':telefone', $t);
            $sql->execute();

            return true;

        } else {

            return false;
        }

    }


    public function validaLogin($e, $s){

        global $pdo;

        $sql = $pdo->prepare('SELECT id FROM usuario WHERE email = :email AND senha = MD5(:senha)');
        $sql->bindValue(':email', $e);
        $sql->bindValue(':senha', $s);
        $sql->execute();


        if($sql->rowCount() > 0){
            
            $dado = $sql->fetch(PDO::FETCH_ASSOC);
            $_SESSION['login'] = $dado['id'];
            return true;

        } else {

            return false;
        }


    }

    public function setUsuario($id){

        global $pdo;

        $sql = "SELECT * FROM usuario WHERE id = :id";
        $sql = $pdo->prepare($sql);
        $sql->bindValue(':id', $id);
        $sql->execute();

        if($sql->rowCount() > 0){

            $dado = $sql->fetchAll(PDO::FETCH_ASSOC);

            $this->__set('nome',$dado[0]['nome']);
            $this->__set('email',$dado[0]['email']);
            $this->__set('senha',$dado[0]['senha']);
            $this->__set('telefone',$dado[0]['telefone']);



        }

    }

    public function getTotalUsuarios(){

        global $pdo;

        $sql = "SELECT count(id) as total FROM usuario";

        $sql = $pdo->prepare($sql);

        $sql->execute();

        $resultado = $sql->fetch(PDO::FETCH_ASSOC);

        $resultado = $resultado['total'] - 1;

        return $resultado;

    }


}