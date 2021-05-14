<?php 
    session_start();
    include_once '../../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Sempre quando eu venho pra control, eu passo uma variável pela url dizendo qual função que o usuário quer.
    //op = 'cad'astro / op = 'alt'erar / op = 'del'etar
    $op = $_GET['op'];

    if($op == 'cad'){
        $nomeClienteCad = isset($_POST['nomeClienteCad']) ? $_POST['nomeClienteCad'] : '';
        $CpfClienteCad = isset($_POST['CpfClienteCad']) ? $_POST['CpfClienteCad'] : '';
        $CelularClienteCad = isset($_POST['CelularClienteCad']) ? $_POST['CelularClienteCad'] : '';
        $TelefoneClienteCad = isset($_POST['TelefoneClienteCad']) ? $_POST['TelefoneClienteCad'] : '';

        //Aqui eu verifico se aquele CPF já foi cadastrado no banco. 
        $selectCPF = "SELECT `cpf_cliente` FROM `clientes` WHERE `cpf_cliente` = '$CpfClienteCad'";
        $stmt = $con->prepare($selectCPF);
        $stmt->execute();
        $arrayCPF = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($arrayCPF) <= 0){

            $sql = "INSERT INTO `clientes`(`nome_cliente`, `cpf_cliente`, `celular_cliente`, `telefone_cliente`) VALUES (?, ?, ?, ?)";
            $stmt = $con->prepare($sql);
            $stmt->bindParam(1, $nomeClienteCad);
            $stmt->bindParam(2, $CpfClienteCad);
            $stmt->bindParam(3, $CelularClienteCad);
            $stmt->bindParam(4, $TelefoneClienteCad);
            $stmt->execute();

            //Session com os dados e variaveis necessárias.
            $_SESSION['alerts'] = 'cadOk';

            header("location: ../../Views/clientes.php");
        }else{

            //Session com os dados e variaveis necessárias.
            $_SESSION['alerts'] = 'cpfExiste';

            header("location: ../../Views/clientes.php");
        }
        
    }elseif(@$op == 'alt'){
    
        $id_cliente = isset($_POST['id_cliente']) ? $_POST['id_cliente'] : '';
        $nomeClienteAlt = isset($_POST['nomeClienteAlt']) ? $_POST['nomeClienteAlt'] : '';
        $cpfClienteAlt = isset($_POST['cpfClienteAlt']) ? $_POST['cpfClienteAlt'] : '';
        $celularClienteAlt = isset($_POST['celularClienteAlt']) ? $_POST['celularClienteAlt'] : '';
        $telefoneClienteAlt = isset($_POST['telefoneClienteAlt']) ? $_POST['telefoneClienteAlt'] : '';

        //Aqui eu primeiro faço um select pra ver se aquele úsuario digitou um novo CPF.
        $sqlSelectCPF = "SELECT `cpf_cliente` FROM `clientes` WHERE `id_cliente` = '$id_cliente'";
        $stmt = $con->prepare($sqlSelectCPF);
        $stmt->execute();
        $ArraySelectCPF = $stmt->fetch();
        $cpf_cliente = $ArraySelectCPF['cpf_cliente'];

        //Se o CPF que ele digitou for diferente do CPF do banco, ele começa a a fazer a nova verificação. 
        if($cpf_cliente != $cpfClienteAlt){

            //Aqui eu verifico se aquele CPF já foi cadastrado no banco. 
            $selectCPF = "SELECT `cpf_cliente` FROM `clientes` WHERE `cpf_cliente` = '$cpfClienteAlt'";
            $stmt = $con->prepare($selectCPF);
            $stmt->execute();
            $arrayCPF = $stmt->fetch();

            //Então o CPF que o úsuario digitou já foi cadastrado no banco por outro usuario.
            if(!empty($arrayCPF)){
                
                //Session com os dados e variaveis necessárias.
                $_SESSION['alerts'] = 'cpfExiste';

                header("location: ../../Views/clientes.php");

            }else{
                //Se ele não existir, faz a alteração conforme o plano. 

                //Aqui eu faço um Select na tabela de clientes, para pegar somente o telefone cadastrado no momento. 
                $sqlSelectCliente = "SELECT `nome_cliente`,`celular_cliente` FROM `clientes` WHERE `id_cliente` = '$id_cliente'";
                $stmt = $con->prepare($sqlSelectCliente);
                $stmt->execute();
                $ArraySelect = $stmt->fetch();
                $nome_cliente = $ArraySelect['nome_cliente'];
                $celular_cliente = $ArraySelect['celular_cliente'];

                //Aqui eu verifico se aquele úsuario possue algum serviço cadastrado. 
                $sqlSelectOS_id = "SELECT `id_os_pendente` FROM `os_pendente` WHERE `id_cliente` = '$id_cliente'";
                $stmt = $con->prepare($sqlSelectOS_id);
                $stmt->execute();
                $ArraySelectOS = $stmt->fetch();
                $Id_os_pendente = $ArraySelectOS['id_os_pendente'];
                
                //Se esse telefone que o usuario digitou for diferente do celular que foi gravado no banco anteriormente. 
                //E ele tiver algum serviço cadastrado.
                //Ele altera na tabela OS o link para chamar o cliente no zap. 
                if($celularClienteAlt != $celular_cliente AND !empty($Id_os_pendente)){
            
                    //Aqui eu filtro a váriavel de nome só pra pegar o primeiro nome da pessoa!
                    $explodePrimeiroName = explode(" ", $nome_cliente);
                    $primeiroNomeCliente = $explodePrimeiroName[0];

                    //Aqui eu filtro o celular vindo do banco, já que eu preciso dele sem () e - . 
                    $filtros = array("(",")","-"," ");
                    $celular_cliente_filtrado = str_replace($filtros, "", $celularClienteAlt);

                    //E aqui eu junto esse telefone no link do WhatsApp.
                    $linkZapCad = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado&text=Ol%C3%A1%20$primeiroNomeCliente%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84";

                    $sqlUpdateOs = "UPDATE `os_pendente` SET `link_webZap` = ? WHERE `id_cliente` = '$id_cliente'";
                    $stmt = $con->prepare($sqlUpdateOs);
                    $stmt->bindParam(1, $linkZapCad);
                    $stmt->execute();

                    $sql = "UPDATE `clientes` SET `nome_cliente`= ?,`cpf_cliente`= ?,`celular_cliente`= ?,`telefone_cliente`= ? WHERE `id_cliente` = '$id_cliente'";
                    $stmt = $con->prepare($sql);
                    $stmt->bindParam(1, $nomeClienteAlt);
                    $stmt->bindParam(2, $cpfClienteAlt);
                    $stmt->bindParam(3, $celularClienteAlt);
                    $stmt->bindParam(4, $telefoneClienteAlt);
                    $stmt->execute();
            
                    //Session com os dados e variaveis necessárias.
                    $_SESSION['alerts'] = 'altOk';
            
                    header("location: ../../Views/clientes.php");
                }else{

                    $sql = "UPDATE `clientes` SET `nome_cliente`= ?,`cpf_cliente`= ?,`celular_cliente`= ?,`telefone_cliente`= ? WHERE `id_cliente` = '$id_cliente'";
                    $stmt = $con->prepare($sql);
                    $stmt->bindParam(1, $nomeClienteAlt);
                    $stmt->bindParam(2, $cpfClienteAlt);
                    $stmt->bindParam(3, $celularClienteAlt);
                    $stmt->bindParam(4, $telefoneClienteAlt);
                    $stmt->execute();
            
                    //Session com os dados e variaveis necessárias.
                    $_SESSION['alerts'] = 'altOk';
            
                    header("location: ../../Views/clientes.php");
                }
            }
        }elseif($cpf_cliente == $cpfClienteAlt){
            
            //Aqui eu faço um Select na tabela de clientes, para pegar somente o telefone cadastrado no momento. 
            $sqlSelectCliente = "SELECT `nome_cliente`,`celular_cliente` FROM `clientes` WHERE `id_cliente` = '$id_cliente'";
            $stmt = $con->prepare($sqlSelectCliente);
            $stmt->execute();
            $ArraySelect = $stmt->fetch();
            $nome_cliente = $ArraySelect['nome_cliente'];
            $celular_cliente = $ArraySelect['celular_cliente'];

            //Aqui eu verifico se aquele úsuario possue algum serviço cadastrado. 
            $sqlSelectOS_id = "SELECT `id_os_pendente` FROM `os_pendente` WHERE `id_cliente` = '$id_cliente'";
            $stmt = $con->prepare($sqlSelectOS_id);
            $stmt->execute();
            $ArraySelectOS = $stmt->fetch();
            $Id_os_pendente = $ArraySelectOS['id_os_pendente'];


            //Se esse telefone que o usuario digitou for diferente do celular que foi gravado no banco anteriormente. 
            //E ele tiver algum serviço cadastrado.
            //Ele altera na tabela OS o link para chamar o cliente no zap. 
            if($celularClienteAlt != $celular_cliente AND !empty($Id_os_pendente)){

                //Aqui eu filtro a váriavel de nome só pra pegar o primeiro nome da pessoa!
                $explodePrimeiroName = explode(" ", $nome_cliente);
                $primeiroNomeCliente = $explodePrimeiroName[0];

                //Aqui eu filtro o celular vindo do banco, já que eu preciso dele sem () e - . 
                $filtros = array("(",")","-"," ");
                $celular_cliente_filtrado = str_replace($filtros, "", $celularClienteAlt);

                //E aqui eu junto esse telefone no link do WhatsApp.
                $linkZapCad = "https://api.whatsapp.com/send?phone=+55$celular_cliente_filtrado&text=Ol%C3%A1%20$primeiroNomeCliente%2C%20tudo%20bem%3F%20Aqui%20%C3%A9%20da%20Matrix%20Inform%C3%A1tica%2C%20e%20viemos%20avisar%20que%20seu%20o%20seu%20equipamento%20j%C3%A1%20foi%20reparado%2C%20voc%C3%AA%20j%C3%A1%20pode%20vir%20busca-lo!%20%F0%9F%98%84";

                $sqlUpdateOs = "UPDATE `os_pendente` SET `link_webZap` = ? WHERE `id_cliente` = '$id_cliente'";
                $stmt = $con->prepare($sqlUpdateOs);
                $stmt->bindParam(1, $linkZapCad);
                $stmt->execute();

                $sql = "UPDATE `clientes` SET `nome_cliente`= ?,`cpf_cliente`= ?,`celular_cliente`= ?,`telefone_cliente`= ? WHERE `id_cliente` = '$id_cliente'";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(1, $nomeClienteAlt);
                $stmt->bindParam(2, $cpfClienteAlt);
                $stmt->bindParam(3, $celularClienteAlt);
                $stmt->bindParam(4, $telefoneClienteAlt);
                $stmt->execute();
        
                //Session com os dados e variaveis necessárias.
                $_SESSION['alerts'] = 'altOk';
        
                header("location: ../../Views/clientes.php");
            }else{

                $sql = "UPDATE `clientes` SET `nome_cliente`= ?,`cpf_cliente`= ?,`celular_cliente`= ?,`telefone_cliente`= ? WHERE `id_cliente` = '$id_cliente'";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(1, $nomeClienteAlt);
                $stmt->bindParam(2, $cpfClienteAlt);
                $stmt->bindParam(3, $celularClienteAlt);
                $stmt->bindParam(4, $telefoneClienteAlt);
                $stmt->execute();
        
                //Session com os dados e variaveis necessárias.
                $_SESSION['alerts'] = 'altOk';
        
                header("location: ../../Views/clientes.php");
            }
        }

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
    
            header("location: ../../Views/clientes.php");

        }elseif(count($arrayId_usuario) > 0){

            $_SESSION['alerts'] = 'deleteClienteFail';
            
            header("location: ../../Views/clientes.php");
            
        
        }
    }

?>