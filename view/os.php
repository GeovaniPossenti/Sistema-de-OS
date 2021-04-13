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

    //Select que pega os dados pra preencher a tabela de OS.
    $selectOSPendente = "SELECT `p`.`id_os_pendente`, `p`.`nome_equipamento`, `p`.`descricao_defeito`, `p`.`descricao_reparo`, `p`.`status` ,`p`.`data_recebimento`, `p`.`data_entrega_cliente`, `p`.`valor_reparo`, `p`.`link_webZap`, `u`.`nome_cliente` FROM `os_pendente` `P` join `clientes` `U` on (`P`.`id_cliente` = `U`.`id_cliente`)";
	$stmt = $con->prepare($selectOSPendente);
	$stmt->execute();
	$arrayBancoOs = $stmt->fetchAll();

    //Select que pega os dados pra preencher a tabela de OS.
    $selectClientes = "SELECT `id_cliente`, `nome_cliente`, `celular_cliente` FROM `clientes`";
    $stmt = $con->prepare($selectClientes);
    $stmt->execute();
    $arrayClientes = $stmt->fetchAll();
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
                <table id="table_os" class="display text-center">
                    <thead>
                        <tr>
                            <th>ID Ordem de Serviço</th>
                            <th>Nome do Cliente</th>
                            <th>Nome Equipamento</th>
                            <th class="hide">descricao_defeito</th>
                            <th class="hide">descricao_reparo</th>
                            <th>Status</th>
                            <th>Data Recebimento</th>
                            <th class="hide">data_entrega_cliente</th>
                            <th class="">valor_reparo</th>
                            <th class="hide">link_webZap</th>
                            <th>Funcoes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   
                        //Foreach para mostrar a lista com base no Array criado a partir dos dados do banco. 
                            foreach($arrayBancoOs as $row){ ?>
                        <tr>  
                            <td class="btnDetailsOs"><?php echo $row['id_os_pendente']; ?></td>
                            <!--Aqui eu mostro o nome do cliente ao inves do id, usando um inner join no topo da página-->
                            <td class="btnDetailsOs"><?php echo $row['nome_cliente']; ?></td>
                            <!--------------------------------------------------------->
                            <td class="btnDetailsOs"><?php echo $row['nome_equipamento']; ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['descricao_defeito']; ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['descricao_reparo']; ?></td>
                            <td class="btnDetailsOs"><?php echo $row['status']; ?></td>
                            <td class="btnDetailsOs"><?php echo inverteData($row['data_recebimento']); ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['data_entrega_cliente']; ?></td>
                            <td class="btnDetailsOs"><?php echo $row['valor_reparo']; ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['link_webZap']; ?></td>
                            <td class="text-center">
                                <!--Formulario para deletar uma linha no banco-->
                                <form action="../control/controle_os.php?op=del" method="POST">
                                    <input type="button" class="btn btn-outline-primary btnEdit" value="Alterar" onclick="">
                                    <input type="hidden" name="id_os_pendente" value="<?php echo $row['id_os_pendente']; ?>">
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
                            <div class="form-control">
                                <form action="../control/controle_os.php?op=cad" method="POST">
                                    <div class="form-group">                           
                                        <label for="recipient-name" class="col-form-label">Cliente:
                                            <select name="idClienteCad" class="form-control" id="NomeClienteModalCad" required>
                                                <option value="" selected>Selecione um Cliente</option>
                                                <?php foreach($arrayClientes as $rowCliente){ ?>
                                                    <option value="<?php echo $rowCliente['id_cliente']; ?>"><?php echo $rowCliente['nome_cliente']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                        <label for="" class="col-form-label">Nome Equipamento:
                                            <input type="text" name="nomeEquipamentoCad" class="form-control" id="">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Descrição do Defeito:
                                            <textarea class="form-control" name="descDefeitoCad" id=""></textarea>
                                        </label>
                                        <label for="" class="col-form-label">Descrição do Reparo:
                                            <textarea class="form-control" name="descReparoCad" id=""></textarea>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Processo:
                                            <select name="statusCad" class="form-control" name="" id="" required>
                                                <option value="Orçamento">Orçamento</option>
                                                <option value="Aguardando">Aguardando</option>
                                                <option value="processo">Em processo</option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Entregue">Entregue</option>
                                            </select>
                                        </label>
                                        <label for="" class="col-form-label">Data de Entrega ao Cliente:
                                            <input type="date" name="dataEntregaCad" class="form-control">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Valor a cobrar:
                                            <input type="text" name="valorCad" class="form-control" id="">
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
            <!----------------------------> 

            <!--Modal de edição de OS--> 
            <div class="modal fade" id="modalEditOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Alterar OS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="../control/controle_os.php?op=alt" method="POST">
                            <div class="modal-body">
                                <div class="form-control">
                                    <input type="hidden" name="idOsPendenteAlt" id="id_os_pendente" required>
                                    <div class="form-group">                           
                                        <label for="recipient-name" class="col-form-label">Cliente:
                                            <select name="nomeClienteAlt" class="form-control" id="nome_cliente" required>
                                                <?php foreach($arrayClientes as $rowCliente){ ?>
                                                    <option value="<?php echo $rowCliente['nome_cliente']; ?>"><?php echo $rowCliente['nome_cliente']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                        <label for="" class="col-form-label">Nome do Equipamento:
                                            <input type="text" name="nomeEquipamentoAlt" class="form-control" id="nome_equipamento" autofocus>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Descrição do Defeito:
                                            <textarea class="form-control" name="descDefeitoAlt" id="descricao_defeito"></textarea>
                                        </label>
                                        <label for="" class="col-form-label">Descrição do Reparo:
                                            <textarea class="form-control" name="descReparoAlt" id="descricao_reparo"></textarea>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Processo:
                                            <select name="statusCadAlt" class="form-control" id="status" required>
                                                <option value="Orçamento">Orçamento</option>
                                                <option value="Aguardando">Aguardando</option>
                                                <option value="Em Processo">Em Processo</option>
                                                <option value="Finalizado">Finalizado</option>
                                                <option value="Entregue">Entregue</option>
                                            </select>
                                        </label>
                                        <label for="" class="col-form-label">Data de Entrega ao Cliente:
                                            <input type="date" name="dataEntregaAlt" id="data_entrega_cliente" class="form-control">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Valor a cobrar:
                                            <input type="text" name="valorReparoAlt"  id="valor_reparo" class="form-control">
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
            <!----------------------------> 

            <!--Modal de detalhes de OS--> 
            <div class="modal fade" id="modalDetailsOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalhes OS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body form-control">
                            <dl class="dl-horizontal form-control">
								<dt >Descrição do defeito:</dt><textarea class="form-control" id="descricao_defeitoDet" rows="4" cols="64" readonly></textarea>                        
                                <dt style="margin-top: 20px;">Descrição do reparo:</dt><textarea class="form-control" id="descricao_reparoDet" rows="4" cols="64" readonly></textarea>  
                                <dt style="margin-top: 20px;">Data de entrega ao cliente: </dt><input type="date" class="form-control" name="" id="data_entrega_clienteDet" required readonly>
                                <dt style="margin-top: 20px;">Link para mandar mensagem para o cliente: <input type="button" class="form-control" id="link_webZapDet" readonly onclick="window.open(document.getElementById('link_webZapDet').value);"></dt>
							</dl>
                        </div>
                    </div>
                </div>
            </div>

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
                    
                    //console.log(data);

                    $('#id_os_pendente').val(data[0]);
                    $('#nome_cliente').val(data[1]);
                    $('#nome_equipamento').val(data[2]);
                    $('#descricao_defeito').val(data[3]);
                    $('#descricao_reparo').val(data[4]);
                    $('#status').val(data[5]);
                    $('#data_recebimento').val(data[6]);
                    $('#data_entrega_cliente').val(data[7]);
                    $('#valor_reparo').val(data[8]);
                    $('#link_webZap').val(data[9]);
                });
                $('.btnDetailsOs').on('click', function(){
                    $('#modalDetailsOs').modal('show');

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function(){
                        return $(this).text();
                    }).get();
                    
                    //console.log(data);

                    $('#id_os_pendenteDet').val(data[0]);
                    $('#nome_clienteDet').val(data[1]);
                    $('#nome_equipamentoDet').val(data[2]);
                    $('#descricao_defeitoDet').val(data[3]);
                    $('#descricao_reparoDet').val(data[4]);
                    $('#statusDet').val(data[5]);
                    $('#data_recebimentoDet').val(data[6]);
                    $('#data_entrega_clienteDet').val(data[7]);
                    $('#valor_reparoDet').val(data[8]);
                    $('#link_webZapDet').val(data[9]);
                });
                $('.btnCadastro').on('click', function(){
                    $('#modalCadastroOs').modal('show');
                });

            });
        </script>
        <!-- Arquivo JS onde ficam todos os scrips do sistema. -->
        <script src="../tools/js/scriptsmask.js"></script>
    </body>
</html>

<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('../view/alerts.php');
?>
