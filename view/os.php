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
                    <li><a href="#" class="nav-link px-2 text-secondary">OS Finalizadas</a></li>
                </ul>
                <div class="text-end">
                    <a href="../control/logout.php"><button type="button" class="btn btn-danger">Sair</button></a>
                </div>
                </div>
            </div>
        </header>
        <section style="margin-top: 20px;">
            <div class="container text-center" style="margin-bottom: 20px;">
                <input type="button" class="btn btn-info text-white btnCadastro" value="Cadastrar Ordem de Serviço">
            </div>
            <div class="container container-lista" >
                <table id="table_os" class="display text-center">
                    <thead>
                        <!--Aqui eu uso uma classe no css, pra não exibir algumas colunas, 
                        porque lá em baixo quando eu pego os valores de cada linha com o JQUERY, 
                        eu preciso de todos as colunas para assim ter todos os dados. -->
                        <tr>
                            <th>ID OS</th>
                            <th>Nome do Cliente</th>
                            <th>Nome do Equipamento</th>
                            <th class="hide">descricao_defeito</th>
                            <th class="hide">descricao_reparo</th>
                            <th>Status</th>
                            <th>Data de Recebimento</th>
                            <th class="hide">data_entrega_cliente</th>
                            <th class="">Valor do Reparo R$</th>
                            <th class="hide">link_webZap</th>
                            <th>Funções</th>
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
                            <td class="btnDetailsOs"><?php echo $row['id_os_pendente']; ?></td>
                            <!--Aqui eu mostro o nome do cliente ao inves do id, usando um inner join no topo da página-->
                            <td class="btnDetailsOs"><?php echo $row['nome_cliente']; ?></td>
                            <!--------------------------------------------------------->
                            <td class="btnDetailsOs"><?php echo $row['nome_equipamento']; ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['descricao_defeito']; ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['descricao_reparo']; ?></td>
                            <td class="btnDetailsOs" style="color: <?php echo $color; ?>"><?php echo $row['status']; ?></td>
                            <td class="btnDetailsOs"><?php echo inverteData($row['data_recebimento']); ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['data_entrega_cliente']; ?></td>
                            <td class="btnDetailsOs"><?php echo str_replace('.', ',', $row['valor_reparo']); ?></td>
                            <td class="btnDetailsOs hide"><?php echo $row['link_webZap']; ?></td>
                            <td class="text-center">
                                <!--Formulario para deletar uma linha no na tabela de os_pendente. -->
                                <form action="../control/controle_os.php?op=del" method="POST">
                                    <input type="button" class="btn btn-outline-primary btnEdit" value="Alterar" onclick="">
                                    <input type="hidden" name="id_os_pendente" value="<?php echo $row['id_os_pendente']; ?>">
                                    <input type="submit" class="btn btn-outline-danger" value="Deletar">                          
                                </form>
                                <!------------------------------------------------------------------->
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
                            <h5 class="modal-title" id="exampleModalLabel">Cadastrar Novas Ordens de Serviços</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Formulario de cadastro de OS. -->
                        <form action="../control/controle_os.php?op=cad" method="POST">
                            <div class="modal-body">
                                <div class="form-control">                   
                                    <div class="form-group">                           
                                        <label for="recipient-name" class="col-form-label">Cliente:
                                            <select name="idClienteCad" class="form-control" id="NomeClienteModalCad" required>
                                                <option value="" selected>Selecione um Cliente</option>
                                                <?php foreach($arrayClientes as $rowCliente){ ?>
                                                    <option value="<?php echo $rowCliente['id_cliente']; ?>"><?php echo $rowCliente['nome_cliente']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </label>
                                        <label for="" class="col-form-label">Nome do Equipamento:
                                            <input type="text" name="nomeEquipamentoCad" class="form-control" placeholder="">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Descrição do Defeito:
                                            <textarea class="form-control" name="descDefeitoCad" placeholder="Digite a descrição do defeito" rows="4" cols="64"></textarea>
                                        </label>
                                        <label for="" class="col-form-label">Descrição do Reparo:
                                            <textarea class="form-control" name="descReparoCad" placeholder="Digite a descrição do reparo" rows="4" cols="64"></textarea>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Processo:
                                            <select name="statusCad" class="form-control" name="" id="" required>
                                                <option value="Orçamento" style="color: #DAA520">Orçamento</option>
                                                <option value="Aguardando" style="color: #DC143C">Aguardando</option>
                                                <option value="Processando" style="color: #A020F0">Processando</option>
                                                <option value="Finalizado" style="color: #4169E1">Finalizado</option>
                                                <option value="Entregue" style="color: #008000">Entregue</option>
                                            </select>
                                        </label>
                                        <label for="" class="col-form-label">Data de Entrega ao Cliente:
                                            <input type="date" name="dataEntregaCad" class="form-control">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Valor a cobrar:
                                            <input type="text" name="valorCad" class="inputDinheiro form-control" placeholder="Digite um valor">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                        </form>
                        <!--------------------------->
                    </div>
                </div>
            </div>
            <!-----------------------------------------------> 

            <!--Modal de edição de OS--> 
            <div class="modal fade" id="modalEditOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Alterar as Ordens de Serviços</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Formulario de alteração de OS. -->
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
                                            <textarea class="form-control" name="descDefeitoAlt" id="descricao_defeito" placeholder="Digite a descrição do defeito" rows="4" cols="64"></textarea>
                                        </label>
                                        <label for="" class="col-form-label">Descrição do Reparo:
                                            <textarea class="form-control" name="descReparoAlt" id="descricao_reparo" placeholder="Digite a descrição do reparo" rows="4" cols="64"></textarea>
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Processo:
                                            <select name="statusCadAlt" class="form-control" id="status" required>
                                            <option value="Orçamento" style="color: #DAA520">Orçamento</option>
                                                <option value="Aguardando" style="color: #DC143C">Aguardando</option>
                                                <option value="Processando" style="color: #A020F0">Processando</option>
                                                <option value="Finalizado" style="color: #4169E1">Finalizado</option>
                                                <option value="Entregue" style="color: #008000">Entregue</option>
                                            </select>
                                        </label>
                                        <label for="" class="col-form-label">Data de Entrega ao Cliente:
                                            <input type="date" name="dataEntregaAlt" id="data_entrega_cliente" class="form-control">
                                        </label>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-form-label">Valor a cobrar:
                                            <input type="text" name="valorReparoAlt"  id="valor_reparo" class="inputDinheiro form-control" placeholder="Digite um valor">
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-primary">Salvar alterações</button>
                            </div>
                        </form>
                        <!--------------------------->
                    </div>
                </div>
            </div>
            <!----------------------------------------------->  

            <!--Modal de detalhes de OS--> 
            <div class="modal fade" id="modalDetailsOs" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Detalhes das Ordens de Serviços</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body form-control">
                            <dl class="dl-horizontal form-control">
								<dt >Descrição do defeito:</dt><textarea class="form-control" id="descricao_defeitoDet" rows="4" cols="64" placeholder="Não há dados" readonly></textarea>                        
                                <dt style="margin-top: 20px;">Descrição do reparo:</dt><textarea class="form-control" id="descricao_reparoDet" rows="4" cols="64" placeholder="Não há dados" readonly></textarea>  
                                <dt style="margin-top: 20px;">Data de entrega ao cliente: </dt><input type="date" class="form-control" name="" id="data_entrega_clienteDet" readonly>
                                <dt style="margin-top: 20px;">Link para mandar mensagem para o cliente: <input type="button" class="form-control" id="link_webZapDet" readonly onclick="window.open(document.getElementById('link_webZapDet').value);"></dt>
							</dl>
                        </div>
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
