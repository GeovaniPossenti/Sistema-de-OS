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

}

?>
