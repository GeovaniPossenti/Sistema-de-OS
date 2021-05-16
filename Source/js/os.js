    
    //Mascara que arruma o input de valor.
    $('.inputDinheiro').mask('#.##0,00', {
        reverse: true
    });

    //Aqui é onde ficam todos os comandos pra abrir os modais, e manipular os dados dos modais.
    //Aqui ficam as opções da tela de os.php
    $('.btnEdit').on('click', function(){
        $('#modalEditOs').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id_os_pendente').val(data[0]);
        //Aqui eu passo o valor do campo hide, porque ele contém o nome completo do cliente.
        //O campo que eu não atribuo data[2], contém os dois primeiros nomes do cliente.
        //Sendo assim, o select não se auto complementa com o nome, já que o no banco, é o nome completo que consta.
        $('#nomeCompletoCliente').val(data[1]);
        $('#nome_equipamento').val(data[3]);
        $('#descricao_defeito').val(data[4]);
        $('#descricao_reparo').val(data[5]);
        $('#status').val(data[6]);
        $('#data_recebimento').val(data[7]);
        $('#data_entrega_cliente').val(data[8]);
        $('#valor_reparo').val(data[9]);

        //Aqui eu passo o nome do cliente para o primeiro valor do select2.
        //Porque sem isso, ele pega o value normal, porém só quando abrimos o select. 
        //Quando ele ainda está fechado, o nome que aparece é o primeiro da lista. 
        $('.selectEditClientes').val(data[1]).trigger('change.select2');
    });
    $('.btnDetailsOs').on('click', function(){
        $('#modalDetailsOs').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id_os_pendenteDet').val(data[0]);
        //Aqui eu passo o valor do campo hide, porque ele contém o nome completo do cliente.
        //O campo que eu não atribuo data[2], contém somente os dois primeiros nomes do cliente.
        //Sendo assim, o select não se auto complementa com o nome, já que o no banco, é o nome completo que consta.
        $('#nome_clienteDet').val(data[1]);
        $('#nome_equipamentoDet').val(data[3]);
        $('#descricao_defeitoDet').val(data[4]);
        $('#descricao_reparoDet').val(data[5]);
        $('#statusDet').val(data[6]);
        $('#data_recebimentoDet').val(data[7]);
        $('#data_entrega_clienteDet').val(data[8]);
        $('#valor_reparoDet').val(data[9]);

        //Aqui eu passo os valores para os inputs hidden que ficam no form do botão que cria o link do whatsapp.
        $('#hiddenInputIdOs').val(data[0]);
        $('#hiddenInputNomeCliente').val(data[1]);
    });
    $('.btnCadastro').on('click', function(){
        $('#modalCadastroOs').modal('show');
    });
    
    //Campo dinâmica de busca nos selects de clientes.
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
    var nomeEquipamentoCad = document.getElementById('nomeEquipamentoCad');
    
    modalCadastroOs.addEventListener('shown.bs.modal', function () {            
        nomeEquipamentoCad.focus();
    });
