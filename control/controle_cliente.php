<?php 
    @session_start();

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Var passada pelo url.
    @$op = $_GET['op'];

    if(@$op == 'cad'){
        $nomeClienteCad = isset($_POST['nomeClienteCad']) ? $_POST['nomeClienteCad'] : '';
        $CpfClienteCad = isset($_POST['CpfClienteCad']) ? $_POST['CpfClienteCad'] : '';
        $CelularClienteCad = isset($_POST['CelularClienteCad']) ? $_POST['CelularClienteCad'] : '';
        $TelefoneClienteCad = isset($_POST['TelefoneClienteCad']) ? $_POST['TelefoneClienteCad'] : '';

        //Falta verificar se o cliente já existe no banco!

        $sql = "INSERT INTO `clientes`(`nome_cliente`, `cpf_cliente`, `celular_cliente`, `telefone_cliente`) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(1, $nomeClienteCad);
        $stmt->bindParam(2, $CpfClienteCad);
        $stmt->bindParam(3, $CelularClienteCad);
        $stmt->bindParam(4, $TelefoneClienteCad);
        $stmt->execute();

        //Session com os dados e variaveis necessárias.
        $_SESSION['alerts'] = 'cadOk';

        header("location: ../view/clientes.php");

    }elseif(@$op == 'alt'){
        $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
        $nomeClienteAlt = isset($_POST['nomeClienteAlt']) ? $_POST['nomeClienteAlt'] : '';
        $cpfClienteAlt = isset($_POST['cpfClienteAlt']) ? $_POST['cpfClienteAlt'] : '';
        $celularClienteAlt = isset($_POST['celularClienteAlt']) ? $_POST['celularClienteAlt'] : '';
        $telefoneClienteAlt = isset($_POST['telefoneClienteAlt']) ? $_POST['telefoneClienteAlt'] : '';

        //Ainda preciso fazer o update na tabela de OS. Pra isso preciso de um select e um if.

        $sql = "UPDATE `clientes` SET `nome_cliente`= ?,`cpf_cliente`= ?,`celular_cliente`= ?,`telefone_cliente`= ? WHERE `id_cliente` = '$id_cliente'";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(1, $nomeClienteAlt);
        $stmt->bindParam(2, $cpfClienteAlt);
        $stmt->bindParam(3, $celularClienteAlt);
        $stmt->bindParam(4, $telefoneClienteAlt);
        $stmt->execute();

        //Session com os dados e variaveis necessárias.
        $_SESSION['alerts'] = 'altOk';

        header("location: ../view/clientes.php");

    }elseif(@$op == 'del'){
        $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';

        //Aqui eu primeiro verifico se aquele cliente possue algum serviço vinculado. 
        $sql = ("SELECT id_cliente FROM `os_pendente` WHERE `id_cliente` = '$id_cliente'");
		$stmt = $con->prepare($sql);
		$stmt->execute();
        $arrayId_usuario = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Se não possuem eu executo o delete do cliente, se ele possuem algum serviço vinculado, eu exibo mensagem de erro e retorno para a página de clientes.
        if (count($arrayId_usuario) <= 0){

            $sql = ("DELETE FROM `clientes` WHERE `id_cliente` = '$id_cliente'");
            $stmt = $con->prepare($sql);
            $stmt->execute();
    
            //Session com os dados e variaveis necessárias.
            $_SESSION['alerts'] = 'delOk';
    
            header("location: ../view/clientes.php");

        }elseif(count($arrayId_usuario) > 0){

            header("location: ../view/clientes.php");
            $_SESSION['alerts'] = 'deleteClienteFail';
        
        }
    }

?>