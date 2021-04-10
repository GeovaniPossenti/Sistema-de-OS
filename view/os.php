<?php 
    session_start();
    $login = $_SESSION['logged_in'];

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Controle de acesso, só é possível acessar os.php/clientes.php com a session de logged_in.
    if($login != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }
    
    $selectCliente = "SELECT `id_evento`, `id_usuario`, `nome_evento`, `desc_evento`, `color`, `inicio_evento`, `final_evento` FROM `eventos`";
	$stmt = $con->prepare($selectCliente);
	$stmt->execute();
	$clientes = $stmt->fetchAll();
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!--Bootstrap.-->
        <script src="../tools/lib/bootstrap-5.0.0-beta3-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../tools/lib/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
        <!--JQuery.-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
        <!--Script dos alertas.-->
        <link rel="stylesheet" href="../tools/lib/alertifyjs/css/alertify.min.css" />
        <link rel="stylesheet" href="../tools/lib/alertifyjs/css/themes/default.min.css" />
        <script src="../tools/lib/alertifyjs/alertify.min.js"></script>
        <!--DataTables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
        <script>
            $(document).ready( function () {
                $('#table_os').DataTable();
            } );
        </script>
        <title>Matrix</title>
    </head>
    <body>
        <header class="bg-dark text-white">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom "> 
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"/></svg>
                </a>

                <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="os.php" class="nav-link px-2 text-white">Ordens de Serviços</a></li>
                    <li><a href="clientes.php" class="nav-link px-2 text-white">Clientes</a></li>
                </ul>

                <div class="col-md-3 text-middle">
                    <a href="../control/logout.php"><button type="button" class="btn btn-danger">Sair</button></a>
                </div>
            </div>
        </header>
        <section>
            <div class="container text-start">
                <table id="table_os" class="display">
                    <thead>
                        <tr>
                            <th>id_evento</th>
                            <th>id_usuario</th>
                            <th>nome_evento</th>
                            <th>desc_evento</th>
                            <th>color</th>
                            <th>inicio_evento</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        //Foreach para mostrar a lista com base no Array criado a partir dos dados do banco. 
                            foreach($clientes as $row){ ?>
                        <tr>
                            <td><?php echo $row['id_evento']; ?></td>
                            <td><?php echo $row['id_usuario']; ?></td>
                            <td>
                            <?php 
                                //If para verificar o tamanho da string e restringir a sua exibição. 
                                if(strlen($row['nome_evento']) > 5){
                                    //$textArray = $row['nome_evento'];
                                    $textCut = substr($row['nome_evento'], 0, 10);
                                    echo "$textCut...";
                                }else{
                                    echo $row['nome_evento'];
                                }
                            ?>
                            </td>
                            <td><?php echo $row['desc_evento']; ?></td>
                            <td><?php echo $row['color']; ?></td>
                            <td><?php echo $row['inicio_evento']; ?></td>
                            <td class="text-center">
                                <input type="button" class="btn btn-outline-info" value="Detalhes">
                                <input type="button" class="btn btn-outline-primary" value="Alterar">
                            </td>
                            <td>
                                <form action="../control/controle_os.php?op=del" method="POST">
                                    <input type="hidden" name="id_servico" value="<?php echo $row['id_evento']; ?>" id="bt1">
                                    <input type="submit" class="btn btn-outline-danger" value="Deletar">                                   
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

        <footer>
        
        </footer>
        <script>
            document.getElementById("bt1").style.display = "none";
        
        </script>
    </body>
</html>

<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('../view/alerts.php');
?>
