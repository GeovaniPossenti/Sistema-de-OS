<?php
    session_start();
    $login = $_SESSION['logged_in'];

    //Controle de acesso, só é possível acessar os.php/clientes.php com a session de logged_in != de vazio.
    if($login != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }

    include '../App/Models/Mysql.php';
    include '../App/Models/OrderService.php';
    include '../App/Models/Customer.php';

    //Listagem de Ordens de Serviço
    $mysql = new Mysql;
    $con = Mysql::getInstance();
    $dbModelOs = new OrderService($con);
    $arrayBancoOs = $dbModelOs->listaOS();

    //Listagem de clientes nos selects.
    $dbModelCustomer = new Customer($con);
    $arrayClientes = $dbModelCustomer->listarClientesOrderBy();
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
        <!--Select2-->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../Source/css/select2-bootstrap5.min.css">
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!--CSS da página. -->
        <link rel="stylesheet" href="../Source/css/styleOs.css">
        <!-- Fonte da CDN do Google -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
        <script>
            $(document).ready( function () {
                $('#table_os').DataTable({
                    lengthMenu: [25, 50, 75, 100],
                    language: {
                        "lengthMenu": "Exibir _MENU_ linhas por página",
                        "zeroRecords": "Nada encontrado!",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "Nenhum registro disponível",
                        "infoFiltered": "(filtrado de _MAX_ registros totais)",
                        "emptyTable": "Não há dados para exibir!",
                        "loadingRecords": "Carregando...",
                        "processing": "Em processamento...",
                        "search": "Procurar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                    },
                });
            } );
        </script>     
    </head>
    <body class="fundo">
        <header class="p-3 text-white header">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">                        
                    <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <img src="../Source/img/computador-pessoal.png" alt="" width="40px" height="40px" title="Logo">
                    </a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" style="margin-left: 20px;">
                        <li><a href="os.php" class="nav-link px-2 text-white" title="Página com a lista de Ordens de Serviços"><i class="fas fa-clipboard"></i> Ordens de Serviço</a></li>
                        <li><a href="clientes.php" class="nav-link px-2 text-secondary" title="Página com a lista de Clientes"><i class="fas fa-user-friends"></i> Lista de Clientes</a></li>
                        <li><a href="#" class="nav-link px-2 text-secondary"></a></li>
                    </ul>
                    <div class="text-end">
                        <a href="../App/Controls/logout.php"><button type="button" class="btn btn-danger" title="Logout"><i class="fas fa-sign-out-alt"></i> Sair</button></a>
                    </div>
                </div>
            </div>
        </header>
        <section>
            <div class="quadrado">
                <div class="container text-center" style="margin-bottom: 20px;">
                    <button type="button" class="btn btn-primary text-white btnCadastro" value="" title="Cadastro de OS"><i class="fas fa-plus"></i> Cadastrar Ordem de Serviço</button>
                </div>
                <div>
                    <table id="table_os" class="display text-center cell-border">
                        <thead style="color: white;">
                            <!--Aqui eu uso uma classe no css, pra não exibir algumas colunas, 
                            porque lá em baixo quando eu pego os valores de cada linha com o JQUERY, 
                            eu preciso de todos as colunas para assim ter todos os dados. -->
                            <tr>
                                <th title="Filtrar por:">ID OS</th>
                                <th title="Filtrar por:">Nome do Cliente</th>
                                <th title="Filtrar por:">Nome do Equipamento</th>
                                <th class="hide">descricao_defeito</th>
                                <th class="hide">descricao_reparo</th>
                                <th title="Filtrar por:">Status</th>
                                <th title="Filtrar por:">Data de Recebimento</th>
                                <th class="hide">data_entrega_cliente</th>
                                <th title="Filtrar por:">Valor do Reparo R$</th>
                                <th title="Filtrar por:">Funções</th>
                                <th title="Filtrar por:"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- A mesma coisa acontece aqui, eu preciso colocar a mesma qtd de colunas pra tabela funcionar, 
                            porém preciso usar uma classe no css pra deixar essas colunas não visíveis.-->
                            <?php foreach($arrayBancoOs as $row){ 
                                //Aqui eu faço um switch pra decidir qual cor eu exibo o texto no campo de status. (Apenas uma função pra melhorar a leitura)
                                switch($row['status']){
                                    case 'Orçamento': 
                                        $color = "#DAA520";
                                    break;                               
                                    case 'Aguardando': 
                                        $color = "#DC143C";
                                    break;
                                    case 'Processando': 
                                        $color = "#A020F0";
                                    break;
                                    case 'Finalizado': 
                                        $color = "#4169E1";
                                    break;
                                    case 'Entregue': 
                                        $color = "#008000";
                                    break;
                                }                        
                            ?>
                            <tr>  
                                <td class="btnDetailsOs" title="Ver todos os detalhes"><?php echo $row['id_os_pendente']; ?></td>
                                <!--Aqui eu mostro o nome do cliente ao inves do id, usando um inner join no topo da página-->
                                <td class="btnDetailsOs" title="Ver todos os detalhes"><?php echo $row['nome_cliente']; ?></td>
                                <!--------------------------------------------------------->
                                <td class="btnDetailsOs" title="Ver todos os detalhes"><?php echo $row['nome_equipamento']; ?></td>
                                <td class="btnDetailsOs hide"><?php echo $row['descricao_defeito']; ?></td>
                                <td class="btnDetailsOs hide"><?php echo $row['descricao_reparo']; ?></td>
                                <td class="btnDetailsOs" style="color: <?php echo $color; ?>" title="Ver todos os detalhes"><?php echo $row['status']; ?></td>
                                <td class="btnDetailsOs" title="Ver todos os detalhes"><?php echo $mysql->inverteData($row['data_recebimento']); ?></td>
                                <td class="btnDetailsOs hide"><?php echo $row['data_entrega_cliente']; ?></td>
                                <td class="btnDetailsOs" title="Ver todos os detalhes"><?php echo str_replace('.', ',', $row['valor_reparo']); ?></td>
                                <td class="text-center">
                                    <!--Formulario para deletar uma linha no na tabela de os_pendente. -->
                                    <form action="../App/Controls/control_os.php?op=del" method="POST">
                                        <button type="button" class="btn btn-outline-primary btnEdit" value="Alterar" title="Alterar">
                                            <i class="far fa-edit"></i>
                                        </button>
                                        <input type="hidden" name="id_os_pendente" value="<?php echo $row['id_os_pendente']; ?>">
                                        <button type="submit" class="btn btn-outline-danger" value="Deletar" title="Deletar">
                                            <i class="fas fa-backspace"></i>
                                        </button>
                                    </form>
                                    <!------------------------------------------------------------------->
                                </td>                                    
                                <td class="text-center">
                                    <?php if($row['status'] == 'Entregue'){ ?>           
                                        <form action="relatorio.php" method="POST" target="_blank">
                                            <input type="hidden" value="<?php echo $row['id_os_pendente']; ?>" name="idOsPendenteRelatorio">
                                            <button type="submit" class="btn btn-outline-warning" title="Gerar Relatório">
                                                <i class="fas fa-file-pdf"></i>
                                            </button>
                                        </form>
                                    <?php } ?>
                                </td>   
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <!--Modal de cadastro de OS--> 
                <div class="modal fade modalfade text-start" id="modalCadastroOs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Cadastrar ordens de serviços</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Formulario de cadastro de OS. -->
                            <form action="../App/Controls/control_os.php?op=cad" method="POST">
                                <div class="modal-body">
                                    <div class="container">                   
                                        <div class="row g-3 gy-3">  
                                            <div class="col-md-6">    
                                                <div style="margin-top: -5px;">
                                                    <label for="NomeClienteModalCad" class="">Selecione um Cliente:</label>
                                                    <select name="idClienteCad" class="form-select" id="NomeClienteModalCad" required>
                                                        <option value="" selected>Selecione</option>
                                                        <?php foreach($arrayClientes as $rowCliente){ ?>
                                                            <option value="<?php echo $rowCliente['id_cliente']; ?>"><?php echo $rowCliente['nome_cliente']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6"> 
                                                <div class="form-floating">
                                                    <input type="text" name="nomeEquipamentoCad" class="form-control" id="nomeEquipamentoCad" maxlength="255">
                                                    <label for="nomeEquipamentoCad">Nome do Equipamento:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12"> 
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="descDefeitoCad" id="descDefeitoCad" style="height: 150px" maxlength="255"></textarea>
                                                    <label for="descDefeitoCad">Descrição do Defeito:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12"> 
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="descReparoCad" id="descReparoCad" style="height: 150px" maxlength="255"></textarea>
                                                    <label for="descReparoCad">Descrição do Reparo:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-5"> 
                                                <div class="form-floating">
                                                    <select name="statusCad" class="form-select" id="statusCad" required>
                                                        <option value="Orçamento" style="color: #DAA520">Orçamento</option>
                                                        <option value="Aguardando" style="color: #DC143C">Aguardando</option>
                                                        <option value="Processando" style="color: #A020F0">Processando</option>
                                                        <option value="Finalizado" style="color: #4169E1">Finalizado</option>
                                                        <option value="Entregue" style="color: #008000">Entregue</option>
                                                    </select>
                                                    <label for="statusCad">Processo:</label>
                                                </div>
                                            </div> 
                                            <div class="col-md-7"> 
                                                <div class="form-floating">
                                                    <input type="date" name="dataEntregaCad" id="dataEntregaCad" class="form-control">
                                                    <label for="dataEntregaCad">Data de Entrega ao Cliente:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 input-group"> 
                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                                <div class="form-floating">
                                                    <input type="text" name="valorCad" id="valorCad" class="inputDinheiro form-control">
                                                    <label for="valorCad">Valor do serviço:</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancelar"><i class="fas fa-times"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-primary" title="Salvar"><i class="fas fa-check"></i> Salvar</button>
                                </div>
                            </form>
                            <!--------------------------->
                        </div>
                    </div>
                </div>
                <!-----------------------------------------------> 

                <!--Modal de edição de OS--> 
                <div class="modal fade modalfade text-start" id="modalEditOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar ordens de serviços</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Formulario de alteração de OS. -->
                            <form action="../App/Controls/control_os.php?op=alt" method="POST">
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row g-3 gy-3">  
                                            <div class="col-md-6">
                                                <input type="hidden" name="idOsPendenteAlt" id="id_os_pendente" required>         
                                                <div style="margin-top: -5px;">
                                                    <label for="nome_cliente">Selecione um Cliente:</label>
                                                    <select name="nomeClienteAlt" class="form-control selectEditClientes nome_cliente" id="nome_cliente" required>
                                                        <?php foreach($arrayClientes as $rowCliente){ ?>
                                                            <option value="<?php echo $rowCliente['nome_cliente']; ?>"><?php echo $rowCliente['nome_cliente']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input type="text" name="nomeEquipamentoAlt" class="form-control" id="nome_equipamento" maxlength="255">
                                                    <label for="nome_equipamento">Nome do Equipamento:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="descDefeitoAlt" id="descricao_defeito" style="height: 150px" maxlength="255"></textarea>
                                                    <label for="descricao_defeito">Descrição do Defeito:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control" name="descReparoAlt" id="descricao_reparo" style="height: 150px" maxlength="255"></textarea>
                                                    <label for="descricao_reparo">Descrição do Reparo:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-floating">
                                                    <select name="statusCadAlt" class="form-select" id="status" required>
                                                        <option value="Orçamento" style="color: #DAA520">Orçamento</option>
                                                        <option value="Aguardando" style="color: #DC143C">Aguardando</option>
                                                        <option value="Processando" style="color: #A020F0">Processando</option>
                                                        <option value="Finalizado" style="color: #4169E1">Finalizado</option>
                                                        <option value="Entregue" style="color: #008000">Entregue</option>
                                                    </select>
                                                    <label for="status">Processo:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-floating">
                                                    <input type="date" name="dataEntregaAlt" id="data_entrega_cliente" class="form-control">
                                                    <label for="data_entrega_cliente" class="col-form-label">Data de Entrega ao Cliente:</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 input-group"> 
                                                <span class="input-group-text" id="basic-addon1">R$</span>
                                                <div class="form-floating">
                                                    <input type="text" name="valorReparoAlt"  id="valor_reparo" class="inputDinheiro form-control" placeholder="Digite um valor">
                                                    <label for="valor_reparo">Valor a cobrar:</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancelar"><i class="fas fa-times"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-primary" title="Salvar"><i class="fas fa-check"></i> Salvar alterações</button>
                                </div>
                            </form>
                            <!--------------------------->
                        </div>
                    </div>
                </div>
                <!----------------------------------------------->  

                <!--Modal de detalhes de OS--> 
                <div class="modal fade modalfade text-start" id="modalDetailsOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Detalhes sobre a ordem de serviço</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row g-3 gy-3">  
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="id_os_pendenteDet" readonly>
                                                <label for="id_os_pendenteDet">Código da OS:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="nome_clienteDet" readonly>
                                                <label for="nome_clienteDet">Nome do Cliente:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="nome_equipamentoDet" readonly>
                                                <label for="nome_equipamentoDet">Nome do Equipamento:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="statusDet" readonly>
                                                <label for="statusDet">Processo:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" id="descricao_defeitoDet" style="height: 150px" readonly></textarea>        
                                                <label for="descricao_defeitoDet">Descrição do defeito:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" id="descricao_reparoDet" style="height: 150px" readonly></textarea>
                                                <label for="descricao_reparoDet">Descrição do reparo:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="data_recebimentoDet" readonly>
                                                <label for="data_recebimentoDet">Data de recebimento:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="date" class="form-control" name="" id="data_entrega_clienteDet" readonly>
                                                <label for="data_entrega_clienteDet">Data de entrega ao cliente:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" class="form-control" id="valor_reparoDet" readonly>
                                                <label for="valor_reparoDet">Valor do cobrado:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-center">
<!--                                            <button type="button" class="btn text-white btnZap" id="link_webZapDet" onclick="window.open(document.getElementById('link_webZapDet').value);" title="Chamar cliente via WhatsApp">-->
<!--                                                <i class="fab fa-whatsapp" style="font-size: 20px; margin-top: 5px;"></i> WhatsApp -->
<!--                                            </button>-->
                                            <form action="../App/Controls/link_whatsapp.php" method="POST" target="_blank">
                                                <input type="hidden" name="idOsPendenteDet" id="hiddenInputIdOs">
                                                <input type="hidden" name="nomeClienteDet" id="hiddenInputNomeCliente">
                                                <button type="submit" class="btn text-white btnZap" id="link_webZapDet" title="Chamar cliente via WhatsApp">
                                                    <i class="fab fa-whatsapp" style="font-size: 20px; margin-top: 5px;"></i> WhatsApp
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Fechar"><i class="fas fa-times"></i> Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-----------------------------------------------> 
            </div>
        </section>
        
        <?php include_once('footer.html'); ?>
        
        <!-- Arquivo JS onde ficam os scrips dessa página. -->
        <script src="../Source/js/os.js"></script>
    </body>
</html>
<?php
    //Include da .php onde ficam as funções de alertas, precisa ser incluído no final da página.
    include_once ('alerts.php');
?>
