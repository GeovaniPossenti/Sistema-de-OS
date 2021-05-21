<?php
    session_start();
    //Controle de acesso.
    if(@$_SESSION['logged_in'] != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../../index.php');
    }

    include_once '../Models/Mysql.php';
    include_once '../Models/User.php';

    $op = $_GET['op'];
    if ($op == 'log'){
        $loginUsuario = isset($_POST['usernameLogin']) ? $_POST['usernameLogin'] : '';
        $senhaUsuario = isset($_POST['passwordLogin']) ? md5($_POST['passwordLogin']) : '';

        $con = Mysql::getInstance();
        $dbInstance = new User($con);
        $dados = $dbInstance->verificaUsuario($loginUsuario, $senhaUsuario);

        if (!$dados){
            //Se ele não existir.
            $_SESSION['alerts'] = 'logFail';
            header("location: ../../index.php");
        }else{
            //Se ele existir e for igual ao cadastrado no banco.
            $_SESSION['logged_in'] = true;
            $_SESSION['alerts'] = 'logOk';
            header("location: ../../Views/os.php");
        }
    }
