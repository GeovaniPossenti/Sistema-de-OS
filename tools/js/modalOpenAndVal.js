   
    //Aqui é onde ficam todos os comandos pra abrir os modais, manipular dados dentros dos modais.
    $(document).ready(function () {
        //Aqui ficam as opçoes da tela de os.php
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
            
            console.log(data);

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



        //Aqui ficam as opçoes da página de cliente.php 
        $('.btnEdit').on('click', function(){
            $('#modalEditClientes').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function(){
                return $(this).text();
            }).get();
            
            //console.log(data);

            $('#id_cliente').val(data[0]);
            $('#nome_cliente').val(data[1]);
            $('#cpf_cliente').val(data[2]);
            $('#celular_cliente').val(data[3]);
            $('#telefone_cliente').val(data[4]);
        });
        $('.btnCadastro').on('click', function(){
            $('#modalCadastroClientes').modal('show');
        });

            
        //Aqui eu arrumo o autofocus dos modais da tela de clientes.php
        //Por algum motivo que eu desconheço, eu não posso deixar eles no mesmo arquivo. ????
        var modalModalEditClientes = document.getElementById('modalEditClientes');
        var myInputNome_cliente = document.getElementById('nome_cliente');
        
        modalModalEditClientes.addEventListener('shown.bs.modal', function () {            
            myInputNome_cliente.focus();
        });

        var modalmodalCadastroClientes = document.getElementById('modalCadastroClientes');
        var myInputnomeClienteCad = document.getElementById('nomeClienteCad');
        
        modalmodalCadastroClientes.addEventListener('shown.bs.modal', function () {            
            myInputnomeClienteCad.focus();
        });
    });
    