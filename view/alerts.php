<script>
    alertify.set('notifier','position', 'top-right');
    //alertify.success('Current position : ' + alertify.get('notifier','position'));

    //Alertas sobre os eventos.
    function alert1(){
        alertify.message('Seja bem vindo!');
    }
    function alert2(){
        alertify.error('Dados Incorretos!');
    }
    function alert3(){
        alertify.message('Deslogado com Sucesso!');
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
    function alert7(){
        alertify.error('Não é possível deletar clientes que possuem serviços vinculados!');
    }
    function alert8(){
        alertify.error('CPF já foi cadastrado!');
    }
    function alert9(){
        alertify.error('Ocorreu um erro ao executar está operação!');
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
        case 'deleteClienteFail': echo '<script> alert7(); </script>';
        $_SESSION['alerts'] = ' ';
        break;
        case 'cpfExiste': echo '<script> alert8(); </script>'; 
        $_SESSION['alerts'] = ' ';
        break;
        case 'crudFail': echo '<script> alert9(); </script>';
        $_SESSION['alerts'] = ' ';
        break;
    }
?>