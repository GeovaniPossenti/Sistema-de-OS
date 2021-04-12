<?php
    @session_start();

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Var passada pelo url.
    @$op = $_GET['op'];   
        
    if($op == 'cad'){

        $idClienteCad = isset($_POST['idClienteCad']) ? $_POST['idClienteCad'] : '';
        $nomeEquipamentoCad = isset($_POST['nomeEquipamentoCad']) ? $_POST['nomeEquipamentoCad'] : '';
        $descDefeitoCad = isset($_POST['descDefeitoCad']) ? $_POST['descDefeitoCad'] : '';
        $descReparoCad = isset($_POST['descReparoCad']) ? $_POST['descReparoCad'] : '';
        $statusCad = isset($_POST['statusCad']) ? $_POST['statusCad'] : '';
        //Aqui eu crio uma variavel com a data atual do cadastramento da OS.
        $dataRecebimentoCad = date('Y-m-d');
        $dataEntregaCad = isset($_POST['dataEntregaCad']) ? $_POST['dataEntregaCad'] : '';
        $valorCad = isset($_POST['valorCad']) ? $_POST['valorCad'] : '';

        //E aqui eu junto esse telefone no link do WhatsApp, para assim conseguir chama-lo posteriormente.
        $linkZapCad = "https://github.com/GeovaniPossenti";

        //Aqui eu faço um Select na tabela de clientes, para pegar o telefone do cliente cadastrado no serviço.

        $sqlInsertOS = "INSERT INTO `os_pendente`(`id_cliente`, `nome_equipamento`, `descricao_defeito`, `descricao_reparo`, `status`, `data_recebimento`, `data_entrega_cliente`, `valor_reparo`, `link_webZap`) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sqlInsertOS);
        $stmt->bindParam(1, $idClienteCad);
        $stmt->bindParam(2, $nomeEquipamentoCad);
        $stmt->bindParam(3, $descDefeitoCad);
        $stmt->bindParam(4, $descReparoCad);
        $stmt->bindParam(5, $statusCad);
        $stmt->bindParam(6, $dataRecebimentoCad);
        $stmt->bindParam(7, $dataEntregaCad);
        $stmt->bindParam(8, $valorCad);
        $stmt->bindParam(9, $linkZapCad);
        $stmt->execute();
        
        //Session com os dados e variaveis necessárias.
        $_SESSION['alerts'] = 'cadOk';

        header("location: ../view/os.php");

    }elseif($op == 'alt'){

    }elseif($op == 'del'){
        $id_os_pendente = isset($_POST['id_os_pendente']) ? $_POST['id_os_pendente'] : '';

		$sql = ("DELETE FROM `os_pendente` WHERE id_os_pendente = '$id_os_pendente'");
		$stmt = $con->prepare($sql);
		$stmt->execute();

        //Session com os dados e variaveis necessárias.
        $_SESSION['alerts'] = 'delOk';

        header("location: ../view/os.php");
    }

?>