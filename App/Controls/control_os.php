<?php
    session_start();

    include '../Models/Mysql.php';
    include '../Models/OrderService.php';
    include '../Models/Customer.php';

    $con = Mysql::getInstance();

	date_default_timezone_set('America/Sao_Paulo');

    $op = $_GET['op'];
    if($op == 'cad') {
        $idClienteCad = isset($_POST['idClienteCad']) ? $_POST['idClienteCad'] : '';
        $nomeEquipamentoCad = isset($_POST['nomeEquipamentoCad']) ? $_POST['nomeEquipamentoCad'] : '';
        $descDefeitoCad = isset($_POST['descDefeitoCad']) ? $_POST['descDefeitoCad'] : '';
        $descReparoCad = isset($_POST['descReparoCad']) ? $_POST['descReparoCad'] : '';
        $statusCad = isset($_POST['statusCad']) ? $_POST['statusCad'] : '';
        $dataRecebimentoCad = date('Y-m-d');
        $dataEntregaCad = isset($_POST['dataEntregaCad']) ? $_POST['dataEntregaCad'] : '';
        $valorCad = isset($_POST['valorCad']) ? $_POST['valorCad'] : '';

        //Aqui eu formato o valor que eu recebo do input, já que eu preciso dele com o formato 00000.00 pra gravar no banco.
        //Primeiro eu tiro todos os pontos.
        $valorSemVirgula = str_replace('.', '', $valorCad);
        //Depois mudo a virgulo por ponto, assim ficando no foramto 00000.00.
        $valorReparoAltFormatado = str_replace(',', '.', $valorSemVirgula);

        //Pegar o nome/telefone daquele cliente.
        $dbInstance = new Customer($con);
        $ArraySelect = $dbInstance->selectTelefoneClienteById($idClienteCad);
        foreach ($ArraySelect as $row){
            $nome_cliente = $row['nome_cliente'];
            $celular_cliente = $row['celular_cliente'];
        }

        //Aqui eu filtro a variável de nome só pra pegar o primeiro nome da pessoa!
        $explodePrimeiroName = explode(" ", $nome_cliente);
        $primeiroNomeCliente = $explodePrimeiroName[0];

        //Aqui eu filtro o celular vindo do banco, já que eu preciso dele sem () e - .
        $filtros = array("(", ")", "-", " ");
        $celular_cliente_filtrado = str_replace($filtros, "", $celular_cliente);

        //E aqui eu junto esse telefone no link do WhatsApp.
        $linkZapCad = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado&text=Ol%C3%A1%20$primeiroNomeCliente%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84";

        $dbInstance = new OrderService($con);
        $dados = $dbInstance->insertOs($idClienteCad, $nomeEquipamentoCad, $descDefeitoCad, $descReparoCad, $statusCad, $dataRecebimentoCad, $dataEntregaCad, $valorReparoAltFormatado, $linkZapCad);

        //Se o método for != true, ele exibe um erro. Senão, ele exibe mensagem de ok.
        if(!$dados){
            $_SESSION['alerts'] = 'crudFail';
            header("location: ../../Views/os.php");
        }else {
            //Session com os dados e variáveis necessárias.
            $_SESSION['alerts'] = 'cadOk';
            header("location: ../../Views/os.php");
        }
    }
    elseif($op == 'alt'){
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
        //Depois mudo a virgulo por ponto, assim ficando no formato 00000.00.
        $valorReparoAltFormatado = str_replace(',', '.', $valorSemVirgula);

        //Aqui eu dou um select pra pegar o id do cliente, já que no input eu sou obrigado a passar somente o nome dele.
        //Aqui eu faço um Select na tabela de clientes, para pegar o telefone do cliente cadastrado no serviço.
        $dbInstance = new Customer($con);
        $ArraySelect = $dbInstance->selectNomeClienteByName($nomeClienteAlt);

        foreach ($ArraySelect as $row){
            $id_cliente_update = $row['id_cliente'];
            $nome_cliente = $row['nome_cliente'];
            $celular_cliente = $row['celular_cliente'];
        }

        //Aqui eu filtro a variável de nome só pra pegar o primeiro nome da pessoa!
        $explodePrimeiroName = explode(" ", $nome_cliente);
        $primeiroNomeCliente = $explodePrimeiroName[0];

        //Aqui eu filtro o celular vindo do banco, já que eu preciso dele sem () e - .
        $filtros = array("(",")","-"," ");
        $celular_cliente_filtrado = str_replace($filtros, "", $celular_cliente);

        //E aqui eu junto esse telefone no link do WhatsApp.
        $linkZapCad = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado&text=Ol%C3%A1%20$primeiroNomeCliente%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84";

        //Aqui eu chamo a classe/método pra dar update na tabela.
        $dbInstance = new OrderService($con);
        $updateOs = $dbInstance->updateOs($idOsPendenteAlt, $id_cliente_update, $nomeEquipamentoAlt, $descDefeitoAlt, $descReparoAlt, $statusCadAlt, $dataEntregaAlt, $valorReparoAltFormatado, $linkZapCad);

        //Se o método for != true, ele exibe um erro. Senão, ele exibe mensagem de ok.
        if(!$updateOs){
            $_SESSION['alerts'] = 'crudFail';
            header("location: ../../Views/os.php");
        }else{
            $_SESSION['alerts'] = 'altOk';
            header("location: ../../Views/os.php");
        }

    }
    elseif($op == 'del'){
        $id_os_pendente = isset($_POST['id_os_pendente']) ? $_POST['id_os_pendente'] : '';

        $dbInstance = new OrderService($con);
        $deleteOs = $dbInstance->deleteOs($id_os_pendente);

		if(!$deleteOs){
            $_SESSION['alerts'] = 'crudFail';
            header("location: ../../Views/os.php");
        }else{
            $_SESSION['alerts'] = 'delOk';
            header("location: ../../Views/os.php");
        }

    }
