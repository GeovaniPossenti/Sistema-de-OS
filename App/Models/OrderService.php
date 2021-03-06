<?php

class OrderService{
    private $con;

    public function __construct($conMysql){
        $this->con = $conMysql;
    }

    public function listaOS(){
        $query = "SELECT `p`.`id_os_pendente`, `p`.`nome_equipamento`, `p`.`descricao_defeito`, `p`.`descricao_reparo`, `p`.`status` ,`p`.`data_recebimento`, `p`.`data_entrega_cliente`, `p`.`valor_reparo`, `u`.`nome_cliente` FROM `os_pendente` `P` join `clientes` `U` on (`P`.`id_cliente` = `U`.`id_cliente`)";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function selectOsById($idOsPendente){
        $query = "SELECT `p`.`id_os_pendente`, `p`.`nome_equipamento`, `p`.`descricao_defeito`, `p`.`descricao_reparo`,`p`.`data_recebimento`, `p`.`data_entrega_cliente`, `p`.`valor_reparo`, `u`.`nome_cliente` FROM `os_pendente` `P` join `clientes` `U` on (`P`.`id_cliente` = `U`.`id_cliente`) WHERE `id_os_pendente` = '".$idOsPendente."'";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function insertOs($idClienteCad, $nomeEquipamentoCad, $descDefeitoCad, $descReparoCad, $statusCad, $dataRecebimentoCad, $dataEntregaCad, $valorReparoAltFormatado){
        $query = "INSERT INTO `os_pendente`(`id_cliente`, `nome_equipamento`, `descricao_defeito`, `descricao_reparo`, `status`, `data_recebimento`, `data_entrega_cliente`, `valor_reparo`) VALUES ('".$idClienteCad."','".$nomeEquipamentoCad."','".$descDefeitoCad."','".$descReparoCad."','".$statusCad."','".$dataRecebimentoCad."','".$dataEntregaCad."','".$valorReparoAltFormatado."')";
        $sql = $this->con->insertQuery($query);
        return $sql;
    }

    public function updateOs($idOsPendenteAlt, $id_cliente_update, $nomeEquipamentoAlt, $descDefeitoAlt, $descReparoAlt, $statusCadAlt, $dataEntregaAlt, $valorReparoAltFormatado){
        $query = "UPDATE `os_pendente` SET `id_cliente`= '".$id_cliente_update."',`nome_equipamento`= '".$nomeEquipamentoAlt."',`descricao_defeito`= '".$descDefeitoAlt."',`descricao_reparo`= '".$descReparoAlt."',`status`= '".$statusCadAlt."',`data_entrega_cliente`= '".$dataEntregaAlt."',`valor_reparo`= '".$valorReparoAltFormatado."' WHERE `id_os_pendente` = '".$idOsPendenteAlt."'";
        $sql = $this->con->alterQuery($query);
        return $sql;
    }

    public function deleteOs($id_os_pendente){
        $query = "DELETE FROM `os_pendente` WHERE id_os_pendente = '".$id_os_pendente."'";
        $sql = $this->con->deleteQuery($query);
        return $sql;
    }

    public function inverteData($data){
        if (count(explode("/", $data)) > 1) {
            return implode("-", array_reverse(explode("/", $data)));
        } elseif (count(explode("-", $data)) > 1) {
            return implode("/", array_reverse(explode("-", $data)));
        }
    }
}
