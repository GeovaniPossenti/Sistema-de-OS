    
    //Mascara que arruma o input de valor.
    $('.inputDinheiro').mask('#.##0,00', {
        reverse: true
    });

    //Aqui é onde ficam todos os comandos pra abrir os modais, manipular dados dentros dos modais.
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

        //Aqui eu passo o nome do cliente para o primeiro valor do select2.
        $('.selectEditClientes').val(data[1]).trigger('change.select2');
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
    
    //Campo dinamica de busca nos selects de clientes. 
    //Select de cadastro de OS.
    $('#NomeClienteModalCad').select2({
        dropdownParent: $('#modalCadastroOs'),
        placeholder: 'Selecione...',
        //width: 'resolve',
        theme: "bootstrap5",
        //theme: "classic",
        allowClear: true,
    });

    //Select de edição de OS.
    $('.selectEditClientes').select2({
        dropdownParent: $('#modalEditOs'),
        placeholder: 'Selecione...',
        theme: "bootstrap5",
        allowClear: true,
        selectOnClose: true,
        
    });

    //Aqui eu arrumo o autofocus dos modais.
    //Por algum motivo que eu desconheço, eu não posso deixar eles no mesmo arquivo. ????
    var modalEditOs = document.getElementById('modalEditOs');
    var myInputNome_equipamento = document.getElementById('nome_equipamento');

    modalEditOs.addEventListener('shown.bs.modal', function () {            
        myInputNome_equipamento.focus();
    });

    var modalCadastroOs = document.getElementById('modalCadastroOs');
    var myInputNomeClienteModalCad = document.getElementById('NomeClienteModalCad');
    
    modalCadastroOs.addEventListener('shown.bs.modal', function () {            
        myInputNomeClienteModalCad.focus();
    });
