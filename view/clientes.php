<?php 
    //Starto a sessão e pego o SESSION da váriavel que diz se eu estou logado ou não.
    session_start();
    $login = $_SESSION['logged_in'];

    //Include da conexão com o banco.
    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Controle de acesso, só é possível acessar os.php/clientes.php com a session de logged_in != de vazio.
    if($login != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }
    
    //Select que pega os dados pra preencher a tabela de Clientes.
    $selectCliente = "SELECT `id_cliente`, `nome_cliente`, `cpf_cliente`, `celular_cliente`, `telefone_cliente` FROM `clientes`";
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
        <title>Matrix</title>
        <!-- Logo da página. -->
		<link rel="shorcut icon" href="../tools/img/computador-pessoal.png">
        <!--CSS da página. -->
        <link rel="stylesheet" href="../tools/css/styleClientes.css">
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
                $('#table_clientes').DataTable({
                    "lengthMenu": [25, 50, 75, 100],
                    
                });
            } );
        </script>
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
                <input type="button" class="btn btn-info btnCadastro text-white" value="Cadastrar Clientes">
            </div>
            <div class="container text-start container-lista" >
                <table id="table_clientes" class="display text-center">
                    <thead>
                        <tr>
                            <th>Id do Cliente</th>
                            <th>Nome do Cliente</th>
                            <th>CPF do Cliente</th>
                            <th>Celular do Cliente</th>
                            <th>Telefone do Cliente</th>
                            <th>Funções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clientes as $row){ ?>
                        <tr>
                            <td class="btnEdit"><?php echo $row['id_cliente']; ?></td>
                            <td class="btnEdit"><?php echo $row['nome_cliente']; ?></td>
                            <td class="btnEdit"><?php echo $row['cpf_cliente']; ?></td>
                            <td class="btnEdit"><?php echo $row['celular_cliente']; ?></td>
                            <td class="btnEdit"><?php echo $row['telefone_cliente']; ?></td>
                            <td class="text-center">
                                <!--Formulario para deletar um cliente do banco. -->
                                <form action="../control/controle_cliente.php?op=del" method="POST">
                                    <input type="button" class="btn btn-outline-primary btnEdit" value="Alterar" onclick="">
                                    <input type="hidden" name="id_cliente" value="<?php echo $row['id_cliente']; ?>">
                                    <input type="submit" class="btn btn-outline-danger" value="Deletar">                          
                                </form>
                                <!------------------------------------------------->
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--Modal de cadastro de Clientes--> 
            <div class="modal fade" id="modalCadastroClientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastro de Clientes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../control/controle_cliente.php?op=cad" method="POST">
                            <div class="modal-body">
                                <div class="container">
                                    <div class="form-control">
                                        <label for="recipient-name" class="col-form-label">Nome:
                                            <input type="text" name="nomeClienteCad" class="form-control" id="nomeClienteCad" required autofocus>
                                        </label>
                                        <label for="recipient-name" class="col-form-label">CPF:
                                            <input type="text" name="CpfClienteCad" class="form-control" id="recipient-name" placeholder="000.000.000-00" onkeyup="mascara('###.###.###-##',this,event,true)" maxlength="14" required>
                                        </label>

                                        <label for="recipient-name" class="col-form-label">Celular:
                                            <input type="text" name="CelularClienteCad" class="form-control phone" placeholder="(00) 00000-0000" onkeyup="mascara('(##) #####-####',this,event,true)" maxlength="15" required>
                                        </label>
                                        <label for="recipient-name" class="col-form-label">Telefone:
                                            <input type="text" name="TelefoneClienteCad" class="form-control phone" placeholder="(00) 0000-0000" onkeyup="mascara('(##) ####-####',this,event,true)" maxlength="14" required>
                                        </label>                 
 
                                    </div>
                                </div>
                            </div>                                       
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!----------------------------------------------->  

            <!--Modal de edição de CLientes--> 
            <div class="modal fade" id="modalEditClientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modificar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../control/controle_cliente.php?op=alt" method="POST">
                        <div class="modal-body">
                            <div class="container">
                                <div class="form-control">
                                    <input type="hidden" name="id_cliente" id="id_cliente">
                                    <label for="form-control" class="col-form-label">Nome:
                                        <input type="text" name="nomeClienteAlt" class="form-control" id="nome_cliente" required autofocus>
                                    </label>
                                    <label for="form-control" class="col-form-label">CPF:
                                        <input type="text" name="cpfClienteAlt" class="form-control" id="cpf_cliente" placeholder="000.000.000-00" onkeyup="mascara('###.###.###-##',this,event,true)" maxlength="14" required>
                                    </label>
                                    <label for="form-control" class="col-form-label">Celular:
                                        <input type="text" name="celularClienteAlt" class="form-control" id="celular_cliente" placeholder="(00) 00000-0000" onkeyup="mascara('(##) #####-####',this,event,true)" maxlength="15" required>
                                    </label>
                                    <label for="form-control" class="col-form-label">Telefone:
                                        <input type="text" name="telefoneClienteAlt" class="form-control" id="telefone_cliente" placeholder="(00) 0000-0000" onkeyup="mascara('(##) ####-####',this,event,true)" maxlength="14" required>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Salvar alterações</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
            <!-----------------------------------------------> 

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

        <!-- Aqui ficam os triggers para abrir os modais, e também 
        os comandos pra pegar os values da tabela dinamica e coloca-los em ids .-->
        <script src="../tools/js/modalOpenAndVal.js"></script>
        <!-- Arquivo JS onde ficam todos os scrips do sistema. -->
        <script src="../tools/js/scripts.js"></script>
    </body>
</html>
<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('../view/alerts.php');
?>