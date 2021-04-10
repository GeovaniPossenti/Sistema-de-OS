<?php 
    session_start();
    $login = $_SESSION['logged_in'];
    $user_id = $_SESSION['user_id']; 

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    if($login != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }
    
    $selectCliente = "SELECT `id_usuario`, `nome_usuario`, `email_usuario` FROM `usuario`";
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
                    <li><a href="../view/os.php?view=os" class="nav-link px-2 text-white">Ordens de Serviços</a></li>
                    <li><a href="../view/os.php?view=c" class="nav-link px-2 text-white">Clientes</a></li>
                </ul>

                <div class="col-md-3 text-middle">
                    <a href="../control/logout.php"><button type="button" class="btn btn-danger">Sair</button></a>
                </div>
            </div>
        </header>
        <section>
            <?php
                @$tela = $_GET['view'];

                if(@$tela == "os" OR empty(@$tela)){
                    echo "Sera mostrada a tela da lista de OS";
            ?>
            <div class="container">
                <table id="table_os" class="display">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Funcões</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                            foreach($clientes as $array){ ?>
                        <tr>
                            <td><?php echo $array['id_usuario']; ?></td>
                            <td><?php echo $array['nome_usuario']; ?></td>
                            <td><?php echo $array['email_usuario']; ?></td>
                            <td>
                                <input type="button" class="btn btn-danger" value="Excluir">
                                <input type="button" class="btn btn-primary" value="Alterar">
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
                
            <?php
                }elseif(@$tela == "c"){ 
                echo "Sera mostrada a tela da lista de Clientes";
            ?>
            <div class="container">
                <table id="table_os" class="display">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                            foreach($clientes as $array){ ?>
                        <tr>
                            <td><?php echo $array['nome_usuario']; ?></td>
                            <td><?php echo $array['email_usuario']; ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <?php
            
            }

            ?>
        </section>

        <footer>
        
        </footer>
    </body>
</html>

<?php
    include_once ('../view/alerts.php');
?>
