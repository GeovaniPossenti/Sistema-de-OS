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
    
    //Select random só pra pegar dados e popular a tabela dinamica.
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
                $('#table_os').DataTable({
                    "lengthMenu": [25, 50, 75, 100]
                });
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
            <div class="container">
                <table id="table_os" class="display">
                    <thead>
                        <tr>
                            <th>id_usuario</th>
                            <th>nome_usuario</th>
                            <th>email_usuario</th>
                            <th>Funcoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  
                            foreach($clientes as $row){ ?>
                        <tr>
                            <td><?php echo $row['id_usuario']; ?></td>
                            <td><?php echo $row['nome_usuario']; ?></td>
                            <td><?php echo $row['email_usuario']; ?></td>
                            <td class="text-center">
                                    <input type="button" class="btn btn-outline-primary" value="Alterar">
                                    <input type="button" class="btn btn-outline-danger" value="Excluir">
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

        </section>

        <footer class="bd-footer bg-dark p-3 p-md-5 mt-5 bg-light text-center text-sm-start">
            <div class="container">
                <ul class="bd-footer-links ps-0 mb-3">
                    <li class="d-inline-block"><a href="https://github.com/twbs"></a></li>
                    <li class="d-inline-block ms-3"><a href="https://twitter.com/getbootstrap"></a></li>
                    <li class="d-inline-block ms-3"><a href="/docs/5.0/examples/"></a></li>
                    <li class="d-inline-block ms-3"><a href="/docs/5.0/about/overview/"></a></li>
                </ul>
                <p class="mb-0"><a href="/docs/5.0/about/team/"></a><a href="https://github.com/twbs/bootstrap/graphs/contributors"></a></p>
                <p class="mb-0"><a href="https://github.com/twbs/bootstrap/blob/main/LICENSE" target="_blank" rel="license noopener"></a><a href="https://creativecommons.org/licenses/by/3.0/" target="_blank" rel="license noopener"></a></p>
            </div>
        </footer>
    </body>
</html>
<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('../view/alerts.php');
?>