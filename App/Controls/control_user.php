<?php

session_start();

include '../Models/Mysql.php';
include '../Models/User.php';

$op = $_GET['op'];
if ($op == 'log'){
    $loginUsuario = isset($_POST['usernameLogin']) ? $_POST['usernameLogin'] : '';
    $senhaUsuario = isset($_POST['passwordLogin']) ? $_POST['passwordLogin'] : '';
    $senhaUsuarioMD5 = md5($senhaUsuario);

    $con = Mysql::getInstance();
    $dbInstance = new User($con);
    $dados = $dbInstance->verificaUsuario($loginUsuario, $senhaUsuarioMD5);

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
