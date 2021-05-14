<?php

class OrderService{
    private $con;

    public function __construct($conMysql){
        $this->con = $conMysql;
    }

    public function listaOS(){
        $query = "SELECT `p`.`id_os_pendente`, `p`.`nome_equipamento`, `p`.`descricao_defeito`, `p`.`descricao_reparo`, `p`.`status` ,`p`.`data_recebimento`, `p`.`data_entrega_cliente`, `p`.`valor_reparo`, `p`.`link_webZap`, `u`.`nome_cliente` FROM `os_pendente` `P` join `clientes` `U` on (`P`.`id_cliente` = `U`.`id_cliente`)";
        $sql = $this->con->readQuery($query);
        return $sql;
    }

    public function insertOs($idClienteCad, $nomeEquipamentoCad, $descDefeitoCad, $descReparoCad, $statusCad, $dataRecebimentoCad, $dataEntregaCad, $valorReparoAltFormatado, $linkZapCad){
        $query = "INSERT INTO `os_pendente`(`id_cliente`, `nome_equipamento`, `descricao_defeito`, `descricao_reparo`, `status`, `data_recebimento`, `data_entrega_cliente`, `valor_reparo`, `link_webZap`) VALUES ('".$idClienteCad."','".$nomeEquipamentoCad."','".$descDefeitoCad."','".$descReparoCad."','".$statusCad."','".$dataRecebimentoCad."','".$dataEntregaCad."','".$valorReparoAltFormatado."','".$linkZapCad."')";
        $sql = $this->con->insertQuery($query);
        return $sql;
    }

    public function updateOs($idOsPendenteAlt, $id_cliente_update, $nomeEquipamentoAlt, $descDefeitoAlt, $descReparoAlt, $statusCadAlt, $dataEntregaAlt, $valorReparoAltFormatado, $linkZapCad){
        $query = "UPDATE `os_pendente` SET `id_cliente`= '".$id_cliente_update."',`nome_equipamento`= '".$nomeEquipamentoAlt."',`descricao_defeito`= '".$descDefeitoAlt."',`descricao_reparo`= '".$descReparoAlt."',`status`= '".$statusCadAlt."',`data_entrega_cliente`= '".$dataEntregaAlt."',`valor_reparo`= '".$valorReparoAltFormatado."',`link_webZap`= '".$linkZapCad."' WHERE `id_os_pendente` = '".$idOsPendenteAlt."'";
        $sql = $this->con->alterQuery($query);
        return $sql;
    }

    public function deleteOs($id_os_pendente){
        $query = "DELETE FROM `os_pendente` WHERE id_os_pendente = '".$id_os_pendente."'";
        $sql = $this->con->deleteQuery($query);
        return $sql;
    }
}
