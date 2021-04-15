    //Mascara que arruma o input de valor.
    $('.inputDinheiro').mask('#.##0,00', {
        reverse: true
    });

    $('.inputCelular').mask('(00) 00000-0000');
    $('.inputTelefone').mask('(00) 0000-0000');
    $('.inputCPF').mask('000.000.000-00');

    //Aqui eu arrumo o autofocus dos modais da tela de os.php
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
