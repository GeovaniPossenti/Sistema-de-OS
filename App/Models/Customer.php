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

    public function verificaCpfBanco($CpfClienteCad){
        $query = "SELECT `cpf_cliente` FROM `clientes` WHERE `cpf_cliente` = '".$CpfClienteCad."'";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function verificaCpfBancoById($idCpfCliente){
        $query = "SELECT `cpf_cliente` FROM `clientes` WHERE `id_cliente` = '".$idCpfCliente."'";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function verificaOsCliente($id_cliente){
        $query = "SELECT id_cliente FROM `os_pendente` WHERE `id_cliente` = '".$id_cliente."'";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function insertCliente($nomeClienteCad, $CpfClienteCad, $CelularClienteCad, $TelefoneClienteCad){
        $query = "INSERT INTO `clientes`(`nome_cliente`, `cpf_cliente`, `celular_cliente`, `telefone_cliente`) VALUES ('".$nomeClienteCad."', '".$CpfClienteCad."', '".$CelularClienteCad."', '".$TelefoneClienteCad."')";
        $sql = $this->con->insertQuery($query);
        return $sql;
    }

    public function updateCliente($id_cliente, $nomeClienteAlt, $cpfClienteAlt, $celularClienteAlt, $telefoneClienteAlt){
        $query = "UPDATE `clientes` SET `nome_cliente`= '".$nomeClienteAlt."',`cpf_cliente`= '".$cpfClienteAlt."',`celular_cliente`= '".$celularClienteAlt."',`telefone_cliente`= '".$telefoneClienteAlt."' WHERE `id_cliente` = '".$id_cliente."'";
        $sql = $this->con->alterQuery($query);
        return $sql;
    }

    public function deleteCliente($id_cliente){
        $query = "DELETE FROM `clientes` WHERE `id_cliente` = '".$id_cliente."'";
        $sql = $this->con->deleteQuery($query);
        return $sql;
    }
}
