<?php
    @session_start();

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Var passada pelo url.
    @$op = $_GET['op'];   
        
    if($op == 'del'){
        $id = isset($_POST['id_servico']) ? $_POST['id_servico'] : '';

		$sql = ("DELETE FROM `eventos` WHERE id_evento = '$id'");
		$stmt = $con->prepare($sql);
		$stmt->execute();

        //Session com os dados e variaveis necessárias.
        $_SESSION['alerts'] = 'delOk';

        header("location: ../view/os.php");
    }

?>