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
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="../tools/css/style.css">
        <!--Bootstrap.-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
        <!--JQuery.-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
        <!--Script dos alertas.-->
        <link rel="stylesheet" href="../tools/lib/alertifyjs/css/alertify.min.css">
        <link rel="stylesheet" href="../tools/lib/alertifyjs/css/themes/default.min.css">
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
    <body class="fundo-os">
        <header class="bg-dark text-white">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom "> 
                <a href="/" class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
                    <svg class="bi me-2" width="40" height="32"></svg>
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
            <div class="container text-start container-lista" >
                <table id="table_os" class="display">
                    <thead>
                        <tr>
                            <th>id_evento</th>
                            <th>id_usuario</th>
                            <th>nome_evento</th>
                            <th>desc_evento</th>
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
                            <!-- Para verificar o tamanho do texto. 
                            <td>                   
                                //If para verificar o tamanho da string e restringir a sua exibição. 
                                if(strlen($row['nome_evento']) > 50){
                                    $textArray = $row['nome_evento'];
                                    $textCut = substr($row['nome_evento'], 0, 20);
                                    echo "$textCut...";
                                }else{
                                    //echo $row['nome_evento'];
                                }
                            </td> -->

                            <td><?php echo $row['nome_evento']; ?></td>
                            <td><?php echo $row['desc_evento']; ?></td>
                            <td class="text-center">
                                <input type="button" class="btn btn-outline-info" value="Detalhes">
                                <input type="button" class="btn btn-outline-primary btnEdit" value="Alterar" onclick="">
                            </td>
                            <td>
                                <form action="../control/controle_os.php?op=del" method="POST">
                                    <input type="hidden" name="id_servico" value="<?php echo $row['id_evento']; ?>">
                                    <input type="submit" class="btn btn-outline-danger" value="Deletar">                          
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--Modal de edição de OS--> 
            <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" name="" id="update_id">
                        <input type="text" name="" id="id_usuario">
                        <input type="text" name="" id="nome_evento">
                        <input type="text" name="" id="desc_evento">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                </div>
            </div>

        </section>
        <footer>
    
        </footer>

        <script>
            $(document).ready(function () {
                $('.btnEdit').on('click', function(){
                    $('#modalEdit').modal('show');

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function(){
                        return $(this).text();
                    }).get();
                    
                    console.log(data);

                    $('#update_id').val(data[0]);
                    $('#id_usuario').val(data[1]);
                    $('#nome_evento').val(data[2]);
                    $('#desc_evento').val(data[3]);
                });
            });
        </script>

    </body>
</html>

<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('../view/alerts.php');
?>
