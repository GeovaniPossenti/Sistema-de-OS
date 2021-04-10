<?php
    @session_start();

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Var passada pelo url.
    @$op = $_GET['id'];

    $id = isset($_POST['id_servico']) ? $_POST['id_servico'] : '';

    echo $id;

?>