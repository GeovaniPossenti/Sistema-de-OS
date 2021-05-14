<?php
    session_start();

    include '../Models/Mysql.php';
    include '../Models/Customer.php';

    $con = Mysql::getInstance();

    $idOsPendenteDet = $_POST['idOsPendenteDet'];
    $nomeClienteDet = $_POST['nomeClienteDet'];

    echo $idOsPendenteDet;
    echo $nomeClienteDet;

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

    //E aqui eu crio esse link para enfim, redirecionar o usuário para ele.
    $urlZap = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado&text=Ol%C3%A1%20$primeiroNomeCliente%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84";

    //Aqui eu abro o link que eu setei em cima.
    header("Location: $urlZap");