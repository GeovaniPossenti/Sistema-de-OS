<?php
    //Starto a sessão e pego o SESSION da váriavel que diz se eu estou logado ou não.
    session_start();
    $login = $_SESSION['logged_in'];   
    
    //Controle de acesso, só é possível acessar os.php/clientes.php/relatorio.php com a session de logged_in != de vazio.
    if($login != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }

    //Include da conexão com o banco.
    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Select que pega os dados pra preencher a tabela de OS.
    $SelectRelatorio = "SELECT `p`.`id_os_pendente`, `p`.`nome_equipamento`, `p`.`descricao_defeito`, `p`.`descricao_reparo`,`p`.`data_recebimento`, `p`.`data_entrega_cliente`, `p`.`valor_reparo`, `u`.`nome_cliente` FROM `os_pendente` `P` join `clientes` `U` on (`P`.`id_cliente` = `U`.`id_cliente`) WHERE `id_os_pendente` = '$id_os'";
    $stmt = $con->prepare($SelectRelatorio);
    $stmt->execute();
    $arraySelectOS = $stmt->fetch();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Relatório OS</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
        <style>
            @font-face {
                font-family: 'OpenSans';
                src: url("../tools/fonts/Open_Sans/OpenSans-Regular.ttf");
                font-size: 1em;
            }
            @font-face {
                font-family: 'OpenSansLight';
                src: url("../tools/fonts/Open_Sans/OpenSans-light.ttf");
                font-size: 1em;
            }
            @font-face {
                font-family: 'Arciform';
                src: url("../tools/fonts/Arciform/Arciform.otf");
                font-size: 1em;
            }
            @font-face {
                font-family: 'Franca';
                src: url("../tools/fonts/Franca/bold.otf");
                font-size: 1em;
            }
            *{ 
                font-family: OpenSansLight;
                text-align: center;
            }
            .titulo{
                background-color: gray;
            }
        </style>
    </head>
    <body>
        <h1>Relatório de OS</h1>
        <table border="1">
            <thead class="titulo">
                <tr>
                    <td>Nome</td>
                    <td>Nome</td>
                    <td>Data Recebimento</td>
                    <td>Data Entrega</td>
                    <td>Valor Reparo</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $arraySelectOS['nome_cliente']; ?></td>
                    <td><?php echo $arraySelectOS['nome_equipamento']; ?></td>
                    <td><?php echo inverteData($arraySelectOS['data_recebimento']); ?></td>
                    <td><?php echo inverteData($arraySelectOS['data_entrega_cliente']); ?></td>
                    <td><?php echo str_replace('.', ',', ($arraySelectOS['valor_reparo'])); ?></td>
                </tr>
                <tr>
                    <td class="titulo">Desc 1</td>
                    <td class="titulo">Desc 2</td>
                </tr>
                <tr>
                    <td><?php echo $arraySelectOS['descricao_defeito']; ?></td>
                    <td><?php echo $arraySelectOS['descricao_reparo']; ?></td>
                </tr>
            </tbody>
        </table>
        Gerado em: <?php echo date("d-m-Y H:i:s"); ?>
    </body>
</html>