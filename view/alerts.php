<script>
    //Alertas sobre os eventos.
    function alert1(){
        alertify.success('Seja bem vindo!');
    }
    function alert2(){
        alertify.error('Dados Incorretos!');
    }
    function alert3(){
        alertify.warning('Deslogado com Sucesso!');
    }
    function alert4(){
        alertify.success('Deletado com sucesso!');
    }
    function alert5(){
        alertify.success('Cadastrado com sucesso!');
    }
    function alert6(){
        alertify.success('Alterado com sucesso!');
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
        case 'delOk': echo '<script> alert4(); </script>'; 
        $_SESSION['alerts'] = ' ';
        break;
        case 'cadOk': echo '<script> alert5(); </script>'; 
        $_SESSION['alerts'] = ' ';
        break;
        case 'altOk': echo '<script> alert6(); </script>'; 
        $_SESSION['alerts'] = ' ';
        break;
    }
?>