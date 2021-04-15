    //Mascara que arruma o input de valor.
    $('.inputDinheiro').mask('#.##0,00', {
        reverse: true
    });

    $('.inputCelular').mask('(00) 00000-0000');
    $('.inputTelefone').mask('(00) 0000-0000');
    $('.inputCPF').mask('000.000.000-00');
    
    //Função pra validar CPF.
    function TestaCPF(elemento) {
        cpf = elemento.value;
        cpf = cpf.replace(/[^\d]+/g, '');
        if (cpf == '') document.getElementById("btnSalvarCadastroClientes").disabled = true;
        // Elimina CPFs invalidos conhecidos    
        if (cpf.length != 11 ||
            cpf == "00000000000" ||
            cpf == "11111111111" ||
            cpf == "22222222222" ||
            cpf == "33333333333" ||
            cpf == "44444444444" ||
            cpf == "55555555555" ||
            cpf == "66666666666" ||
            cpf == "77777777777" ||
            cpf == "88888888888" ||
            cpf == "99999999999")
            return document.getElementById("btnSalvarCadastroClientes").disabled = true;
        // Valida 1o digito 
        add = 0;
        for (i = 0; i < 9; i++)
            add += parseInt(cpf.charAt(i)) * (10 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(9)))
            return document.getElementById("btnSalvarCadastroClientes").disabled = true;
        // Valida 2o digito 
        add = 0;
        for (i = 0; i < 10; i++)
            add += parseInt(cpf.charAt(i)) * (11 - i);
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11)
            rev = 0;
        if (rev != parseInt(cpf.charAt(10)))
        return document.getElementById("btnSalvarCadastroClientes").disabled = true;
        return document.getElementById("btnSalvarCadastroClientes").disabled = false;
    }


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
