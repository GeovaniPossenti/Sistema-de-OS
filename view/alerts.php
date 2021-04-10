<script>
    //Alertas sobre os eventos.
    function alert1(){
        alertify.success('Seja bem vindo!');
    }
    function alert2(){
        alertify.error('Dados Incorretos!');
    }
    function alert3(){
        alertify.message('Deslogado com Sucesso!');
    }
</script>
<?php

	@$alert = $_SESSION['alerts'];

    //Todos os alertas.
    switch (@$alert){
        case 'logOk': echo '<script> alert1(); </script>'; 
            $_SESSION['alerts'] = ' ';
        break;
        case 'logFail': echo '<script> alert2(); </script>'; 
            $_SESSION['alerts'] = ' ';
        break;
        case 'logout': echo '<script> alert3(); </script>'; 
            $_SESSION['alerts'] = ' ';
        break;
    }
?>