    //Mask para os campos da página cliente.php
    $('.inputCelular').mask('(00) 00000-0000');
    $('.inputTelefone').mask('(00) 0000-0000');
    $('.inputCPF').mask('000.000.000-00');

    //Aqui ficam os open dos modais da página clientes.php
    $('.btnEdit').on('click', function(){
        $('#modalEditClientes').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function(){
            return $(this).text();
        }).get();

        $('#id_cliente').val(data[0]);
        $('#nome_cliente').val(data[1]);
        $('#cpf_cliente').val(data[2]);
        $('#celular_cliente').val(data[3]);
        $('#telefone_cliente').val(data[4]);
    });
    $('.btnCadastro').on('click', function(){
        $('#modalCadastroClientes').modal('show');
    });

    //Function pra remover a notificação de cpf invalido quando clicar fora do input.
    function limparCPF(){
        cpfinput = document.getElementById("inputCPF").value;
        if(cpfinput == ''){
            document.getElementById("inputCPF").classList.remove("is-invalid");
            document.getElementById("inputCPF").classList.remove("is-valid");
        }
    }

    //Função pra validar CPF.
    function TestaCPF(elemento) {
        cpfinput = elemento.value;
        cpf = cpfinput.replace(/[^\d]+/g, '');

        // Elimina CPFs inválidos conhecidos.
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
            cpf == "99999999999"){
            //Tem return
            document.getElementById("btnSalvarCadastroClientes").disabled = true;
            document.getElementById("inputCPF").className += " is-invalid";
            document.getElementById("inputCPF").classList.remove(" is-invalid");
        }
        // Valida 1o digito 
        add = 0;
        for (i = 0; i < 9; i++){
            add += parseInt(cpf.charAt(i)) * (10 - i);
        }
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11){
            rev = 0;
        }
        if (rev != parseInt(cpf.charAt(9))){
            //Tem return
            document.getElementById("btnSalvarCadastroClientes").disabled = true;
            document.getElementById("inputCPF").className += " is-invalid";
            document.getElementById("inputCPF").classList.remove(" is-invalid");
        }
        // Valida 2o digito 
        add = 0;
        for (i = 0; i < 10; i++){
            add += parseInt(cpf.charAt(i)) * (11 - i);
        }
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11){
            rev = 0;
        }
        if (rev != parseInt(cpf.charAt(10))){
            //Tem return
            document.getElementById("btnSalvarCadastroClientes").disabled = true
            document.getElementById("inputCPF").className += " is-invalid";
            document.getElementById("inputCPF").classList.remove(" is-invalid");
        }
        document.getElementById("btnSalvarCadastroClientes").disabled = false;
        document.getElementById("inputCPF").classList.remove("is-invalid");
        document.getElementById("inputCPF").className += " is-valid";
        
    }

    //Function pra remover a notificação de cpf invalido quando clicar fora do input.
    function limparCPF2(){
        cpfinput = document.getElementById("cpf_cliente").value;
        if(cpfinput == ''){
            document.getElementById("cpf_cliente").classList.remove("is-invalid");
            document.getElementById("cpf_cliente").classList.remove("is-valid");
        }
    }

    //Função pra validar CPF.
    function TestaCPF2(elemento) {
        cpfinput = elemento.value;
        cpf = cpfinput.replace(/[^\d]+/g, '');

        // Elimina CPFs inválidos conhecidos.
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
            cpf == "99999999999"){
            //Tem return
            document.getElementById("btnEditarClientes").disabled = true;
            document.getElementById("cpf_cliente").className += " is-invalid";
            document.getElementById("cpf_cliente").classList.remove(" is-invalid");
        }
        // Valida 1o digito 
        add = 0;
        for (i = 0; i < 9; i++){
            add += parseInt(cpf.charAt(i)) * (10 - i);
        }
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11){
            rev = 0;
        }
        if (rev != parseInt(cpf.charAt(9))){
            //Tem return
            document.getElementById("btnEditarClientes").disabled = true;
            document.getElementById("cpf_cliente").className += " is-invalid";
            document.getElementById("cpf_cliente").classList.remove(" is-invalid");
        }
        // Valida 2o digito 
        add = 0;
        for (i = 0; i < 10; i++){
            add += parseInt(cpf.charAt(i)) * (11 - i);
        }
        rev = 11 - (add % 11);
        if (rev == 10 || rev == 11){
            rev = 0;
        }
        if (rev != parseInt(cpf.charAt(10))){
            //Tem return
            document.getElementById("btnEditarClientes").disabled = true
            document.getElementById("cpf_cliente").className += " is-invalid";
            document.getElementById("cpf_cliente").classList.remove(" is-invalid");
        }
        document.getElementById("btnEditarClientes").disabled = false;
        document.getElementById("cpf_cliente").classList.remove("is-invalid");
        document.getElementById("cpf_cliente").className += " is-valid";
        
    }

    //Aqui eu arrumo o autofocus dos modais da tela de clientes.php
    //Por algum motivo que eu desconheço, eu não posso deixar eles no mesmo arquivo. ????
    //Aqui eu seto em vars o modal/botão de open.
    var modalModalEditClientes = document.getElementById('modalEditClientes');
    var myInputNome_cliente = document.getElementById('nome_cliente');
            
    //Aqui eu coloco o focus no input que eu quero.
    modalModalEditClientes.addEventListener('shown.bs.modal', function () {            
        myInputNome_cliente.focus();
    });

    //Aqui eu reseto a validação do CPF quando eu fecho o modal, assim toda vez que ele abrir um novo modal, ele não carrega a informação passada.
    modalModalEditClientes.addEventListener('hidden.bs.modal', function (event) {
        document.getElementById("cpf_cliente").classList.remove("is-invalid");
        document.getElementById("cpf_cliente").classList.remove("is-valid");
        document.getElementById("btnSalvarCadastroClientes").disabled = false;
    });

    //Aqui eu seto em vars o modal/botão de open.
    var modalmodalCadastroClientes = document.getElementById('modalCadastroClientes');
    var myInputnomeClienteCad = document.getElementById('nomeClienteCad');
            
    //Aqui eu coloco o focus no input que eu quero.
    modalmodalCadastroClientes.addEventListener('shown.bs.modal', function () {            
        myInputnomeClienteCad.focus();
    });

    //Aqui eu reseto a validação do CPF quando eu fecho o modal, assim toda vez que ele abrir um novo modal, ele não carrega a informação passada.
    modalmodalCadastroClientes.addEventListener('hidden.bs.modal', function (event) {
        document.getElementById("inputCPF").classList.remove("is-invalid");
        document.getElementById("inputCPF").classList.remove("is-valid");
        document.getElementById("btnSalvarCadastroClientes").disabled = false;
    });