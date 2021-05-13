<?php

class User{
    private $con;

    public function __construct($conMysql){
        $this->con = $conMysql;
    }

    public function verificaUsuario($loginUsuario, $senhaUsuario){
        $query = "SELECT * FROM `usuarios` WHERE BINARY `login_usuario` = '".$loginUsuario."' AND BINARY `senha_usuario` = '".$senhaUsuario."'";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

//    public function cadastraUsers($db, $tabela, $nome, $email, $senha, $palavra, $acesso){
//        $query = "INSERT INTO ".$db.".".$tabela." (NOME, EMAIL, SENHA, PALAVRA, ACESSO) VALUES ('".$nome."', '".$email."', '".$senha."', '".$palavra."', '".$acesso."')";
//        $sql = $this->con->insertQuery($query);
//        return $sql;
//    }
}

?>
