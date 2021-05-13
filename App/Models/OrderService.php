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
}
