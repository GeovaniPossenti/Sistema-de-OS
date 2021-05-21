<?php
    session_start();
    //Controle de acesso.
    if(@$_SESSION['logged_in'] != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }

    include_once '../App/Models/Mysql.php';
    include_once '../App/Models/Customer.php';

    //Listagem de clientes nos selects.
    $con = Mysql::getInstance();
    $dbModelCustomer = new Customer($con);
    $arrayClientes = $dbModelCustomer->listarClientes();

    //Cor do título no include do header.
    $corTituloOS = 'text-secondary';
    $corTituloClientes = 'text-white';
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Matrix</title>
        <!-- Logo da página. -->
		<link rel="shorcut icon" href="../Source/img/computador-pessoal.png">
        <!--Bootstrap.-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
        <!--FontAwesome icons.-->
        <script src="https://kit.fontawesome.com/ff5269617c.js" crossorigin="anonymous"></script>
        <!--JQuery.-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
        <!--Script dos alertas.-->
        <link rel="stylesheet" href="../Source/lib/alertifyjs/css/alertify.min.css">
        <link rel="stylesheet" href="../Source/lib/alertifyjs/css/themes/default.min.css">
        <script src="../Source/lib/alertifyjs/alertify.min.js"></script>
        <!--DataTables-->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
        <!-- Fonte da CDN do Google -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
        <!--CSS da página. -->
        <link rel="stylesheet" href="../Source/css/styleClientes.css">
        <!-- Referência da tabela do DataTables. -->
        <script type="text/javascript" charset="utf8" src="../Source/js/table.js"></script>
    </head>
    <body class="fundo">
        <?php include_once('header.php');?>
        <section>
        <div class="quadrado">
            <div class="container text-center" style="margin-bottom: 20px;">
                <button type="button" class="btn btn-primary btnCadastro text-white" value="" title="Cadastro de Clientes"><i class="fas fa-user-plus"></i> Cadastrar Clientes</button>
            </div>
            <div class="text-start">
                <table id="tabelaDados" class="display text-center cell-border compact">
                    <thead style="color: white;">
                        <tr>
                            <th title="Filtrar por:">Id Cliente</th>
                            <th title="Filtrar por:">Nome do Cliente</th>
                            <th title="Filtrar por:">CPF do Cliente</th>
                            <th title="Filtrar por:">Celular do Cliente</th>
                            <th title="Filtrar por:">Telefone do Cliente</th>
                            <th title="Filtrar por:">Funções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($arrayClientes as $row){ ?>
                        <tr>
                            <td class="btnEdit" title="Alterar"><?php echo $row['id_cliente']; ?></td>
                            <td class="btnEdit" title="Alterar"><?php echo $row['nome_cliente']; ?></td>
                            <td class="btnEdit" title="Alterar"><?php echo $row['cpf_cliente']; ?></td>
                            <td class="btnEdit" title="Alterar"><?php echo $row['celular_cliente']; ?></td>
                            <td class="btnEdit" title="Alterar"><?php echo $row['telefone_cliente']; ?></td>
                            <td class="text-center">
                                <!--Formulário para alterar/excluir um cliente do banco. -->
                                <form action="../App/Controls/control_customer.php?op=del" method="POST">
                                    <button type="button" class="btn btn-outline-primary btnEdit btn-sm" value="Alterar" title="Alterar">
                                        <i class="fas fa-user-edit"></i>
                                    </button>
                                    <input type="hidden" name="id_cliente" value="<?php echo $row['id_cliente']; ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" value="Deletar" title="Deletar">
                                        <i class="fas fa-backspace"></i>
                                    </button>                          
                                </form>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <!--Modal de cadastro de Clientes--> 
            <div class="modal fade modalfade" id="modalCadastroClientes" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastrar clientes</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../App/Controls/control_customer.php?op=cad" method="POST">
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row g-3 gy-3">
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" name="nomeClienteCad" class="form-control" id="nomeClienteCad" placeholder="" maxlength="250" required autofocus>
                                                <label for="nomeClienteCad">Nome:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">                                      
                                                <input type="text" name="CpfClienteCad" class="inputCPF form-control" id="inputCPF" onkeyup="TestaCPF(this)" onfocus="TestaCPF(this)" onblur="limparCPF()" required> <!--onkeyup="TestaCPF(this)"-->
                                                <label for="inputCPF">CPF:</label>
                                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                    Digite um CPF válido!
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">   
                                            <div class="form-floating">                                        
                                                <input type="text" name="CelularClienteCad" class="inputCelular form-control" id="inputCelular" minlength="15" required>
                                                <label for="inputCelular">Celular:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">         
                                            <div class="form-floating">                                      
                                                <input type="text" name="TelefoneClienteCad" class="inputTelefone form-control" id="inputTelefone" minlength="14">
                                                <label for="inputTelefone">Telefone:</label> 
                                            </div>
                                        </div>         
                                    </div>
                                </div>
                            </div>                                       
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancelar"><i class="fas fa-times"></i> Cancelar</button>
                                <button type="submit" class="btn btn-primary" id="btnSalvarCadastroClientes" title="Salvar"><i class="fas fa-check"></i> Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--Modal de edição de Clientes--> 
            <div class="modal fade modalfade" id="modalEditClientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modificar dados de clientes</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="../App/Controls/control_customer.php?op=alt" method="POST">
                        <div class="modal-body">
                            <div class="container">
                                <div class="row g-3 gy-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="hidden" name="id_cliente" id="id_cliente">
                                            <input type="text" name="nomeClienteAlt" class="form-control" id="nome_cliente" placeholder="" maxlength="250" required autofocus>
                                            <label for="nome_cliente">Nome:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">                                      
                                            <input type="text" name="cpfClienteAlt" class="inputCPF form-control" id="cpf_cliente" onkeyup="TestaCPF2(this)" onfocus="TestaCPF2(this)" onblur="limparCPF2()" required> <!--onkeyup="TestaCPF(this)"-->
                                            <label for="cpf_cliente">CPF:</label>
                                            <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                                Digite um CPF válido!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">   
                                        <div class="form-floating">                                        
                                            <input type="text" name="celularClienteAlt" class="inputCelular form-control" id="celular_cliente" minlength="15" required>
                                            <label for="celular_cliente">Celular:</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">         
                                        <div class="form-floating">                                      
                                            <input type="text" name="telefoneClienteAlt" class="inputTelefone form-control" id="telefone_cliente" minlength="14">
                                            <label for="telefone_cliente">Telefone:</label>
                                        </div>
                                    </div>         
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancelar"><i class="fas fa-times"></i> Cancelar</button>
                            <button type="submit" class="btn btn-primary" title="Salvar" id="btnEditarClientes"><i class="fas fa-check"></i> Salvar alterações</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
        </section>

        <?php include_once('footer.html');?>

        <!-- Arquivo JS onde ficam os scrips dessa página. -->
        <script src="../Source/js/clientes.js"></script>
    </body>
</html>
<?php
    //Include dos alertas.
    include_once ('alerts.php');
?>