<?php
    session_start();

    include_once '../Models/Mysql.php';
    include_once '../Models/Customer.php';

    $con = Mysql::getInstance();

    $valorOsDet = $_POST['valorOsDet'];
    $statusOSDet = $_POST['statusOSDet'];
    $nomeClienteDet = $_POST['nomeClienteDet'];

    $dbInstance = new Customer($con);
    $ArraySelect = $dbInstance->selectNomeClienteByName($nomeClienteDet);

    foreach ($ArraySelect as $row){
        $celular_cliente = $row['celular_cliente'];
    }

    //Aqui eu filtro a variável de nome só pra pegar o primeiro nome da pessoa!
    $explodePrimeiroName = explode(" ", $nomeClienteDet);
    $primeiroNomeCliente = $explodePrimeiroName[0];

    //Aqui eu filtro o celular vindo do banco, já que eu preciso dele sem () e - .
    $filtros = array("(",")","-"," ");
    $celular_cliente_filtrado = str_replace($filtros, "", $celular_cliente);

    //E aqui eu crio esse link para enfim, redirecionar o usuário.
    switch($statusOSDet){
        case 'Orçamento':
            $urlZap = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado&text=Ol%C3%A1%20$primeiroNomeCliente%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20o%20or%C3%A7amento%20de%20reparo%20do%20seu%20equipamento%20ficou%20R%24%20$valorOsDet.";
            break;
        case 'Finalizado':
            $urlZap = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado&text=Ol%C3%A1%20$primeiroNomeCliente%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20o%20reparo%20no%20seu%20equipamento%20j%C3%A1%20foi%20realizado%2C%20basta%20agora%20busca-lo%20na%20loja.%20%F0%9F%98%84";
            break;
        default:
            $urlZap = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado";
            break;
    }

    header("Location: $urlZap");