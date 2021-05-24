<?php 
    session_start();
    //Controle de acesso.
    if(@$_SESSION['logged_in'] != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../../index.php');
    }

    include_once '../Models/Mysql.php';
    include_once '../Models/Customer.php';
    include_once '../Models/OrderService.php';

    $con = Mysql::getInstance();
    $dbInstanceCustomers = new Customer($con);
    $dbInstanceOrderService = new OrderService($con);

    $op = $_GET['op'];
    if($op == 'cad'){
        $nomeClienteCad = isset($_POST['nomeClienteCad']) ? $_POST['nomeClienteCad'] : '';
        $CpfClienteCad = isset($_POST['CpfClienteCad']) ? $_POST['CpfClienteCad'] : '';
        $CelularClienteCad = isset($_POST['CelularClienteCad']) ? $_POST['CelularClienteCad'] : '';
        $TelefoneClienteCad = isset($_POST['TelefoneClienteCad']) ? $_POST['TelefoneClienteCad'] : '';

        $dados = $dbInstanceCustomers->verificaCpfBanco($CpfClienteCad);

        if (count($dados) <= 0) {
            $insertClientes = $dbInstanceCustomers->insertCliente($nomeClienteCad, $CpfClienteCad, $CelularClienteCad, $TelefoneClienteCad);
            if (!$insertClientes){
                $_SESSION['alerts'] = 'crudFail';
                header("location: ../../Views/clientes.php");
            }else {
                $_SESSION['alerts'] = 'cadOk';
                header("location: ../../Views/clientes.php");
            }
        }else{
            $_SESSION['alerts'] = 'cpfExiste';
            header("location: ../../Views/clientes.php");
        }
    }
    elseif($op == 'alt'){
        $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
        $nomeClienteAlt = isset($_POST['nomeClienteAlt']) ? $_POST['nomeClienteAlt'] : '';
        $cpfClienteAlt = isset($_POST['cpfClienteAlt']) ? $_POST['cpfClienteAlt'] : '';
        $celularClienteAlt = isset($_POST['celularClienteAlt']) ? $_POST['celularClienteAlt'] : '';
        $telefoneClienteAlt = isset($_POST['telefoneClienteAlt']) ? $_POST['telefoneClienteAlt'] : '';

        //Primeiro eu verifico se o usuário digitou um novo cpf.
        $dados = $dbInstanceCustomers->verificaCpfBancoById($id_cliente);
        foreach ($dados as $dado) {
            $cpfClienteBanco = $dado['cpf_cliente'];
        }

        //Se o CPF que está cadastrado no banco para aquele usuário, for diferente do digitado. Eles faz a verificação padrão, para descobrir se aquele NOVO CPF já existe no banco.
        if($cpfClienteBanco != $cpfClienteAlt){
            $verificaCpf = $dbInstanceCustomers->verificaCpfBanco($cpfClienteAlt);

            if (count($verificaCpf) <= 0) {
                $updateClientes = $dbInstanceCustomers->updateCliente($id_cliente, $nomeClienteAlt, $cpfClienteAlt, $celularClienteAlt, $telefoneClienteAlt);
                if (!$updateClientes){
                    $_SESSION['alerts'] = 'crudFail';
                    header("location: ../../Views/clientes.php");
                }else {
                    $_SESSION['alerts'] = 'altOk';
                    header("location: ../../Views/clientes.php");
                }
            }else{
                $_SESSION['alerts'] = 'cpfExiste';
                header("location: ../../Views/clientes.php");
            }
        }elseif($cpfClienteBanco == $cpfClienteAlt){
            $updateClientes = $dbInstanceCustomers->updateCliente($id_cliente, $nomeClienteAlt, $cpfClienteAlt, $celularClienteAlt, $telefoneClienteAlt);
            if (!$updateClientes){
                $_SESSION['alerts'] = 'crudFail';
                header("location: ../../Views/clientes.php");
            }else {
                $_SESSION['alerts'] = 'altOk';
                header("location: ../../Views/clientes.php");
            }
        }
    }
    elseif($op == 'del'){
        $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';

        $arrayId_usuario = $dbInstanceCustomers->verificaOsCliente($id_cliente);

        if (count($arrayId_usuario) <= 0){
            $dados = $dbInstanceCustomers->deleteCliente($id_cliente);

            if(!$dados){
                $_SESSION['alerts'] = 'crudFail';
                header("location: ../../Views/clientes.php");
            }else {
                $_SESSION['alerts'] = 'delOk';
                header("location: ../../Views/clientes.php");
            }
        }elseif(count($arrayId_usuario) > 0){
            $_SESSION['alerts'] = 'deleteClienteFail';
            header("location: ../../Views/clientes.php");
        }
    }
