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
	$banco_os = $stmt->fetchAll();
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <link rel="stylesheet" href="../tools/css/stylehome.css">
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
                $('#table_os').DataTable({
                    "lengthMenu": [25, 50, 75, 100],
                    
                });
            } );
        </script>
        <title>Matrix</title>
    </head>
    <body>
        <header class="p-3 bg-dark text-white">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                    <li><a href="os.php" class="nav-link px-2 text-white">OS Pendentes</a></li>
                    <li><a href="clientes.php" class="nav-link px-2 text-white">Lista de Clientes</a></li>
                    <li><a href="#" class="nav-link px-2 text-white">OS Finalizadas</a></li>
                </ul>
                <div class="text-end">
                    <a href="../control/logout.php"><button type="button" class="btn btn-danger">Sair</button></a>
                </div>
                </div>
            </div>
        </header>
        <section style="margin-top: 20px;">
            <div class="container" style="margin-bottom: 20px;">
                <input type="button" class="btn btn-info btnCadastro" value="Cadastrar Ordem de Serviços">
            </div>
            <div class="container text-start container-lista" >
                <table id="table_os" class="display">
                    <thead>
                        <tr>
                            <th>id_evento</th>
                            <th>id_usuario</th>
                            <th>nome_evento</th>
                            <th>desc_evento</th>
                            <th>Funcoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        //Foreach para mostrar a lista com base no Array criado a partir dos dados do banco. 
                            foreach($banco_os as $row){ ?>
                        <tr>
                            <td class="btnEdit"><?php echo $row['id_evento']; ?></td>
                            <td class="btnEdit"><?php echo $row['id_usuario']; ?></td>
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

                            <td class="btnEdit"><?php echo $row['nome_evento']; ?></td>
                            <td class="btnEdit"><?php echo $row['desc_evento']; ?></td>
                            <td class="text-center">
                                <!--Formulario para deletar uma linha no banco-->
                                <form action="../control/controle_os.php?op=del" method="POST">
                                    <input type="button" class="btn btn-outline-primary btnEdit" value="Alterar" onclick="">
                                    <input type="hidden" name="id_servico" value="<?php echo $row['id_evento']; ?>">
                                    <input type="submit" class="btn btn-outline-danger" value="Deletar">                          
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--Modal de cadastro de OS--> 
            <div class="modal fade" id="modalCadastroOs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Cadastro de OS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nome:
                                    <input type="text" class="form-control" id="recipient-name" required autofocus>
                                </label>
                                <label for="recipient-name" class="col-form-label">CPF:
                                    <input type="text" class="form-control" id="recipient-name" required>
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Nome:
                                    <input type="text" class="form-control" id="recipient-name" required>
                                </label>
                                <label for="recipient-name" class="col-form-label">CPF:
                                    <input type="text" class="form-control" id="recipient-name" required>
                                </label>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Salvar</button>
                    </div>
                    </div>
                </div>
            </div>
            <!----------------------------> 

            <!--Modal de edição de OS--> 
            <div class="modal fade" id="modalEditOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Alterar OS</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="" id="update_id" required autofocus>
                        <input type="text" name="" id="id_usuario" required>
                        <input type="text" name="" id="nome_evento" required>
                        <input type="text" name="" id="desc_evento" required>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary">Salvar alterações</button>
                    </div>
                    </div>
                </div>
            </div>
            <!----------------------------> 

        </section>

        <!--<footer class="bd-footer bg-dark p-3 p-md-5 mt-5 bg-light text-center text-sm-start">
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
        </footer> -->
        
        <script>
            $(document).ready(function () {
                $('.btnEdit').on('click', function(){
                    $('#modalEditOs').modal('show');

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
                    $('.btnCadastro').on('click', function(){
                        $('#modalCadastroOs').modal('show');
                    });
            });
        </script>
    </body>
</html>

<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('../view/alerts.php');
?>
