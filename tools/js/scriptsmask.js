    //Aqui fica a função que valida telefone, celular e campo de cpf tudo junto. 
    function mascara(o,e,r,t){
        var l=e.selectionStart,a=e.value;a=a.replace(/\D/g,"");var s=a.length,c=o.length;window.event?id=r.keyCode:r.which&&(id=r.which),cursorfixo=!1,l<s&&(cursorfixo=!0);var n=!1;if((16==id||19==id||id>=33&&id<=40)&&(n=!0),ii=0,mm=0,!n){if(8!=id)for(e.value="",j=0,i=0;i<c&&("#"==o.substr(i,1)?(e.value+=a.substr(j,1),j++):"#"!=o.substr(i,1)&&(e.value+=o.substr(i,1)),8==id||cursorfixo||l++,j!=s+1);i++);t&&(e)}cursorfixo&&!n&&l--,e.setSelectionRange(l,l)}

    //Aqui pro autofocus dos modais funcionar certinho.
    //Aqui eu arrumo os modais da tela de OS.php
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