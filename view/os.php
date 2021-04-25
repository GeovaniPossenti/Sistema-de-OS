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

    //Select que pega os dados pra preencher a tabela de OS.
    $selectOSPendente = "SELECT `p`.`id_os_pendente`, `p`.`nome_equipamento`, `p`.`descricao_defeito`, `p`.`descricao_reparo`, `p`.`status` ,`p`.`data_recebimento`, `p`.`data_entrega_cliente`, `p`.`valor_reparo`, `p`.`link_webZap`, `u`.`nome_cliente` FROM `os_pendente` `P` join `clientes` `U` on (`P`.`id_cliente` = `U`.`id_cliente`)";
	$stmt = $con->prepare($selectOSPendente);
	$stmt->execute();
	$arrayBancoOs = $stmt->fetchAll();

    //Select que pega os dados do cliente, eu uso pra exibir no select de clientes, e também pra passar o id dele quando a OS sofrer alteração.
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
        <title>Matrix</title>
        <!-- Logo da página. -->
		<link rel="shorcut icon" href="../tools/img/computador-pessoal.png">
        <!--CSS da página. -->
        <link rel="stylesheet" href="../tools/css/styleOs.css">
        <!--Bootstrap.-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
        <!--Bootstrap icons.-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
        <!--JQuery.-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
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
                    "language": {
                        "lengthMenu": "Exibir _MENU_ linhas por página",
                        "zeroRecords": "Nada encontrado!",
                        "info": "Mostrando página _PAGE_ de _PAGES_",
                        "infoEmpty": "Nenhum registro disponível",
                        "infoFiltered": "(filtrado de _MAX_ registros totais)",
                        "emptyTable": "Sem dados disponíveis na tabela!",
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
    <body>
        <header class="p-3 bg-dark text-white">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">                        
                    <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <img src="../tools/img/computador-pessoal.png" alt="" width="40px" height="40px" title="Logo">
                    </a>
                    <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0" style="margin-left: 20px;">
                        <li><a href="os.php" class="nav-link px-2 text-white" title="Página com a lista de Ordens de Serviços">Ordens de Serviço</a></li>
                        <li><a href="clientes.php" class="nav-link px-2 text-secondary" title="Página com a lista de Clientes">Lista de Clientes</a></li>
                        <li><a href="#" class="nav-link px-2 text-secondary"></a></li>
                    </ul>
                    <div class="text-end">
                        <a href="../control/logout.php"><button type="button" class="btn btn-danger" title="Logout"><i class="bi bi-box-arrow-right"></i></button></a>
                    </div>
                </div>
            </div>
        </header>
        <section style="margin-top: 20px;">
            <div class="container text-center" style="margin-bottom: 20px;">
                <button type="button" class="btn btn-info text-white btnCadastro" value="" title="Cadastro de OS">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/>
                    </svg> Cadastrar Ordem de Serviço
                </button>
            </div>
            <div class="container container-lista" >
                <table id="table_os" class="display text-center">
                    <thead>
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
                            <th class="hide">link_webZap</th>
                            <th title="Filtrar por:">Funções</th>
                            <th title="Filtrar por:"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- A mesma coisa acontece aqui, eu preciso colocar a mesma qtd de colunas pra tabela funcionar, 
                        porém preciso usar uma classe no css pra deixar essas colunas não visiveis.-->
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
                            <td class="btnDetailsOs" title="Ver detalhes"><?php echo $row['id_os_pendente']; ?></td>
                            <!--Aqui eu mostro o nome do cliente ao inves do id, usando um inner join no topo da página-->
                            <td class="btnDetailsOs" title="Ver detalhes"><?php echo $row['nome_cliente']; ?></td>
                            <!--------------------------------------------------------->
                            <td class="btnDetailsOs" title="Ver detalhes"><?php echo $row['nome_equipamento']; ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['descricao_defeito']; ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['descricao_reparo']; ?></td>
                            <td class="btnDetailsOs" style="color: <?php echo $color; ?>" title="Ver detalhes"><?php echo $row['status']; ?></td>
                            <td class="btnDetailsOs" title="Ver detalhes"><?php echo inverteData($row['data_recebimento']); ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['data_entrega_cliente']; ?></td>
                            <td class="btnDetailsOs" title="Ver detalhes"><?php echo str_replace('.', ',', $row['valor_reparo']); ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['link_webZap']; ?></td>
                            <td class="text-center">
                                <!--Formulario para deletar uma linha no na tabela de os_pendente. -->
                                <form action="../control/controle_os.php?op=del" method="POST">
                                    <button type="button" class="btn btn-outline-primary btnEdit" value="Alterar" title="Alterar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <input type="hidden" name="id_os_pendente" value="<?php echo $row['id_os_pendente']; ?>">
                                    <button type="submit" class="btn btn-outline-danger" value="Deletar" title="Deletar">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                                <!------------------------------------------------------------------->
                            </td>                                    
                            <td class="text-center">
                                <?php if($row['status'] == 'Entregue'){ ?>           
                                    <a href="relatorio.php?id=<?php echo $row['id_os_pendente']; ?>"><button type="button" class="btn btn-outline-info" title="Gerar Relatório">
                                        <i class="bi bi-file-earmark-text-fill"></i>
                                    </button></a>
                                <?php } ?>
                            </td>   
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--Modal de cadastro de OS--> 
            <div class="modal fade modalfade" id="modalCadastroOs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cadastrar ordens de serviços</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Formulario de cadastro de OS. -->
                        <form action="../control/controle_os.php?op=cad" method="POST">
                            <div class="modal-body">
                                <div class="container">                   
                                    <div class="row g-3 gy-3">  
                                        <div class="col-md-6">         
                                            <div class="form-floating">
                                                <select name="idClienteCad" class="form-select" id="NomeClienteModalCad" required>
                                                    <option value="" selected>Selecione</option>
                                                    <?php foreach($arrayClientes as $rowCliente){ ?>
                                                        <option value="<?php echo $rowCliente['id_cliente']; ?>"><?php echo $rowCliente['nome_cliente']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label for="" class="">Selecione um Cliente:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6"> 
                                            <div class="form-floating">
                                                <input type="text" name="nomeEquipamentoCad" class="form-control">
                                                <label for="">Nome do Equipamento:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"> 
                                            <div class="form-floating">
                                                <textarea class="form-control" name="descDefeitoCad" style="height: 150px" maxlength="1000"></textarea> 
                                                <label for="">Descrição do Defeito:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12"> 
                                            <div class="form-floating">
                                                <textarea class="form-control" name="descReparoCad" style="height: 150px" maxlength="1000"></textarea> 
                                                <label for="">Descrição do Reparo:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5"> 
                                            <div class="form-floating">
                                                <select name="statusCad" class="form-select" name="" id="" required>
                                                    <option value="Orçamento" style="color: #DAA520">Orçamento</option>
                                                    <option value="Aguardando" style="color: #DC143C">Aguardando</option>
                                                    <option value="Processando" style="color: #A020F0">Processando</option>
                                                    <option value="Finalizado" style="color: #4169E1">Finalizado</option>
                                                    <option value="Entregue" style="color: #008000">Entregue</option>
                                                </select>
                                                <label for="">Processo:</label>
                                            </div>
                                        </div> 
                                        <div class="col-md-7"> 
                                            <div class="form-floating">
                                                <input type="date" name="dataEntregaCad" class="form-control">
                                                <label for="">Data de Entrega ao Cliente:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 input-group"> 
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                            <div class="form-floating">
                                                <input type="text" name="valorCad" class="inputDinheiro form-control">
                                                <label for="">Valor do serviço:</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancelar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary" title="Salvar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                    </svg>Salvar
                                </button>
                            </div>
                        </form>
                        <!--------------------------->
                    </div>
                </div>
            </div>
            <!-----------------------------------------------> 

            <!--Modal de edição de OS--> 
            <div class="modal fade modalfade" id="modalEditOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modificar ordens de serviços</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Formulario de alteração de OS. -->
                        <form action="../control/controle_os.php?op=alt" method="POST">
                            <div class="modal-body">
                                <div class="container">
                                    <div class="row g-3 gy-3">  
                                        <div class="col-md-6">
                                            <input type="hidden" name="idOsPendenteAlt" id="id_os_pendente" required>         
                                            <div class="form-floating">
                                                <select name="nomeClienteAlt" class="form-select" id="nome_cliente" required>
                                                    <?php foreach($arrayClientes as $rowCliente){ ?>
                                                        <option value="<?php echo $rowCliente['nome_cliente']; ?>"><?php echo $rowCliente['nome_cliente']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label for="">Selecione um Cliente:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input type="text" name="nomeEquipamentoAlt" class="form-control" id="nome_equipamento" autofocus>
                                                <label for="">Nome do Equipamento:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="descDefeitoAlt" id="descricao_defeito" style="height: 150px" maxlength="1000"></textarea>
                                                <label for="">Descrição do Defeito:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-floating">
                                                <textarea class="form-control" name="descReparoAlt" id="descricao_reparo" style="height: 150px" maxlength="1000"></textarea>
                                                <label for="">Descrição do Reparo:</label>
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
                                                <label for="">Processo:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="form-floating">
                                                <input type="date" name="dataEntregaAlt" id="data_entrega_cliente" class="form-control">
                                                <label for="" class="col-form-label">Data de Entrega ao Cliente:</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 input-group"> 
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                            <div class="form-floating">
                                                <input type="text" name="valorReparoAlt"  id="valor_reparo" class="inputDinheiro form-control" placeholder="Digite um valor">
                                                <label for="">Valor a cobrar:</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Cancelar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                    </svg>Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary" title="Salvar">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                                    </svg>Salvar alterações
                                </button>
                            </div>
                        </form>
                        <!--------------------------->
                    </div>
                </div>
            </div>
            <!----------------------------------------------->  

            <!--Modal de detalhes de OS--> 
            <div class="modal fade modalfade" id="modalDetailsOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalhes sobre a ordem de serviço</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="container">
                                <div class="row g-3 gy-3">  
                                    <div class="col-md-12">
                                        <label for="">Descrição do defeito:</label>
                                        <textarea class="form-control" id="descricao_defeitoDet" rows="6" cols="64" placeholder="Não há dados..." readonly></textarea>        
                                    </div>
                                    <div class="col-md-12">
                                        <label for="">Descrição do reparo:</label>
                                        <textarea class="form-control" id="descricao_reparoDet" rows="6" cols="64" placeholder="Não há dados..." readonly></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">Data de entrega ao cliente:</label>
                                        <input type="date" class="form-control" name="" id="data_entrega_clienteDet" readonly>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <label for="">Contatar cliente via:</label>
                                        <button type="button" class="btn btn-outline-success" id="link_webZapDet" readonly onclick="window.open(document.getElementById('link_webZapDet').value);" title="Whatsapp">
                                            <i class="bi bi-whatsapp"></i> Whatsapp 
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" title="Fechar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>Fechar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-----------------------------------------------> 

        </section>

        <!-- <footer class="bd-footer fixed-bottom bg-dark p-3 p-md-3 mt-5">
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
        
        <!-- Arquivo JS onde ficam os scrips dessa página. -->
        <script src="../tools/js/os.js"></script>
    </body>
</html>
<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('../view/alerts.php');
?>
