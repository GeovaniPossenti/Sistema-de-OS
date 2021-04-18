<?php
    @session_start();

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Defino o date default para SP.
	date_default_timezone_set('America/Sao_Paulo');
	//Pego a data atual do dia.

    //Sempre quando eu venho pra control, eu passo uma váriavel pela url dizendo qual função que o úsuario quer. 
    //op = 'cad'astro / op = 'alt'erar / op = 'del'etar
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

        //Aqui eu formato o valor que eu recebo do input, já que eu preciso dele com o formato 00000.00 pra gravar no banco.
        //Primeiro eu tiro todos os pontos.
        $valorSemVirgula = str_replace('.', '', $valorCad);
        //Depois mudo a virgulo por ponto, assim ficando no foramto 00000.00.
        $valorReparoAltFormatado = str_replace(',', '.', $valorSemVirgula);

        //Aqui eu faço um Select na tabela de clientes, para pegar o telefone do cliente cadastrado no serviço.
        $sqlSelectCliente = "SELECT `celular_cliente` FROM `clientes` WHERE `id_cliente` = '$idClienteCad'";
        $stmt = $con->prepare($sqlSelectCliente);
        $stmt->execute();
        $ArraySelect = $stmt->fetch();
        $celular_cliente = $ArraySelect['celular_cliente'];

        //Aqui eu filtro o celular vindo do banco, já que eu preciso dele sem () e - . 
        $filtros = array("(",")","-"," ");
        $celular_cliente_filtrado = str_replace($filtros, "", $celular_cliente);

        //E aqui eu junto esse telefone no link do WhatsApp.
        $linkZapCad = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado";

        $sqlInsertOS = "INSERT INTO `os_pendente`(`id_cliente`, `nome_equipamento`, `descricao_defeito`, `descricao_reparo`, `status`, `data_recebimento`, `data_entrega_cliente`, `valor_reparo`, `link_webZap`) VALUES (?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sqlInsertOS);
        $stmt->bindParam(1, $idClienteCad);
        $stmt->bindParam(2, $nomeEquipamentoCad);
        $stmt->bindParam(3, $descDefeitoCad);
        $stmt->bindParam(4, $descReparoCad);
        $stmt->bindParam(5, $statusCad);
        $stmt->bindParam(6, $dataRecebimentoCad);
        $stmt->bindParam(7, $dataEntregaCad);
        $stmt->bindParam(8, $valorReparoAltFormatado);
        $stmt->bindParam(9, $linkZapCad);
        $stmt->execute();
        
        //Session com os dados e variaveis necessárias.
        $_SESSION['alerts'] = 'cadOk';

        header("location: ../view/os.php");

    }elseif($op == 'alt'){

        $idOsPendenteAlt = isset($_POST['idOsPendenteAlt']) ? $_POST['idOsPendenteAlt'] : '';
        $nomeClienteAlt = isset($_POST['nomeClienteAlt']) ? $_POST['nomeClienteAlt'] : '';
        $nomeEquipamentoAlt = isset($_POST['nomeEquipamentoAlt']) ? $_POST['nomeEquipamentoAlt'] : '';
        $descDefeitoAlt = isset($_POST['descDefeitoAlt']) ? $_POST['descDefeitoAlt'] : '';
        $descReparoAlt = isset($_POST['descReparoAlt']) ? $_POST['descReparoAlt'] : '';
        $statusCadAlt = isset($_POST['statusCadAlt']) ? $_POST['statusCadAlt'] : '';
        $dataEntregaAlt = isset($_POST['dataEntregaAlt']) ? $_POST['dataEntregaAlt'] : '';
        $valorReparoAlt = isset($_POST['valorReparoAlt']) ? $_POST['valorReparoAlt'] : '';

        //Aqui eu formato o valor que eu recebo do input, já que eu preciso dele com o formato 00000.00 pra gravar no banco.
        //Primeiro eu tiro todos os pontos.
        $valorSemVirgula = str_replace('.', '', $valorReparoAlt);
        //Depois mudo a virgulo por ponto, assim ficando no foramto 00000.00.
        $valorReparoAltFormatado = str_replace(',', '.', $valorSemVirgula);

        //Aqui eu dou um select pra pegar o id do cliente, já que no input eu sou obrigado a passar somente o nome dele. 
        $sqlSelectIdCliente = "SELECT `id_cliente` FROM `clientes` WHERE `nome_cliente` = '$nomeClienteAlt'";
        $stmt = $con->prepare($sqlSelectIdCliente);
        $stmt->execute();
        $ArraySelect = $stmt->fetch();
        $id_cliente_update = $ArraySelect['id_cliente'];

        //Aqui eu faço um Select na tabela de clientes, para pegar somente o telefone cadastrado no momento. 
        $sqlSelectClienteCelular = "SELECT `celular_cliente` FROM `clientes` WHERE `id_cliente` = '$id_cliente_update'";
        $stmt = $con->prepare($sqlSelectClienteCelular);
        $stmt->execute();
        $ArraySelectCelular = $stmt->fetch();
        $celular_cliente = $ArraySelectCelular['celular_cliente'];

        //Aqui eu filtro o celular vindo do banco, já que eu preciso dele sem () e - . 
        $filtros = array("(",")","-"," ");
        $celular_cliente_filtrado = str_replace($filtros, "", $celular_cliente);
        
        //E aqui eu junto esse telefone no link do WhatsApp.
        $linkZapCad = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado";
        
        //Aqui eu seto o update já colocando um novo cliente caso o usuario tenha mudado.
        $sqlUpdateOs = "UPDATE `os_pendente` SET `id_cliente`=?,`nome_equipamento`= ?,`descricao_defeito`= ?,`descricao_reparo`= ?,`status`= ?,`data_entrega_cliente`= ?,`valor_reparo`= ?,`link_webZap`= ? WHERE `id_os_pendente` = '$idOsPendenteAlt'";
        $stmt = $con->prepare($sqlUpdateOs);
        $stmt->bindParam(1, $id_cliente_update);
        $stmt->bindParam(2, $nomeEquipamentoAlt);
        $stmt->bindParam(3, $descDefeitoAlt);
        $stmt->bindParam(4, $descReparoAlt);
        $stmt->bindParam(5, $statusCadAlt);
        $stmt->bindParam(6, $dataEntregaAlt);
        $stmt->bindParam(7, $valorReparoAltFormatado);
        $stmt->bindParam(8, $linkZapCad);
        $stmt->execute();
        

        //Session com os dados e variaveis necessárias.
        $_SESSION['alerts'] = 'altOk';

        header("location: ../view/os.php");


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