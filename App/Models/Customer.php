<?php

class Customer{
    private $con;

    public function __construct($conMysql){
        $this->con = $conMysql;
    }

    public function listarClientes(){
        $query = "SELECT * FROM `clientes`";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function listarClientesOrderBy(){
        $query = "SELECT `id_cliente`, `nome_cliente`, `celular_cliente` FROM `clientes` ORDER BY `nome_cliente` asc";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function selectTelefoneClienteById($idCliente){
        $query = "SELECT `nome_cliente`, `celular_cliente` FROM `clientes` WHERE `id_cliente` = '".$idCliente."'";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function selectNomeClienteByName($nomeClienteAlt){
        $query = "SELECT `id_cliente`, `nome_cliente`, `celular_cliente` FROM `clientes` WHERE `nome_cliente` = '".$nomeClienteAlt."'";
        $sql = $this->con->readQuery($query);
        return $sql;
    }
}
