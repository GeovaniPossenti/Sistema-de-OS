    //Aqui eu arrumo os modais da tela de Clientes.php
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