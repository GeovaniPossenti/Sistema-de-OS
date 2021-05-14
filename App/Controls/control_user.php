<?php

session_start();

include '../Models/Mysql.php';
include '../Models/User.php';

//Sempre quando eu venho pra control, eu passo uma variável pela url dizendo qual função que o usuário quer.
//op = 'cad'astro / op = 'alt'erar / op = 'del'etar
$op = $_GET['op'];

if ($op == 'log'){
    $loginUsuario = isset($_POST['usernameLogin']) ? $_POST['usernameLogin'] : '';
    $senhaUsuario = isset($_POST['passwordLogin']) ? $_POST['passwordLogin'] : '';
    $senhaUsuarioMD5 = md5($senhaUsuario);

    $con = Mysql::getInstance();
    $dbInstance = new User($con);
    $dados = $dbInstance->verificaUsuario($loginUsuario, $senhaUsuarioMD5);

    if (!$dados){
        //Se ele não existir
        //Set do alerta, e volto pra página de login.
        $_SESSION['alerts'] = 'logFail';
        header("location: ../../index.php");
    }else{
        //Se ele existir
        //Session com os dados e variáveis necessárias.
        $_SESSION['logged_in'] = true;
        $_SESSION['alerts'] = 'logOk';

        header("location: ../../Views/os.php");
    }
}
