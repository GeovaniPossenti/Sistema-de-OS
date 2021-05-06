<?php 
    session_start();
?> 
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Matrix</title>
        <!-- Logo da página. -->
        <link rel="shorcut icon" href="tools/img/computador-pessoal.png">
        <!--CSS da página. -->
        <link rel="stylesheet" href="tools/css/styleIndex.css">
        <!--Bootstrap.-->
        <script src="tools/lib/bootstrap-5.0.0-beta3-dist/js/bootstrap.min.js"></script>
        <link rel="stylesheet" type="text/css" href="tools/lib/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
        <!--JQuery.-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
        <!--Script dos alertas.-->
        <link rel="stylesheet" href="tools/lib/alertifyjs/css/alertify.min.css">
        <link rel="stylesheet" href="tools/lib/alertifyjs/css/themes/default.min.css">
        <script src="tools/lib/alertifyjs/alertify.min.js"></script>
        <!-- Fonte da CDN do Google -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
    </head>
    <body class="fundo">
        <form class="box_form" method="post" action="control/controle_usuario.php?op=log">
            <h1>Login</h1>
            <input type="text" id="" name="usernameLogin" size="" value="" placeholder="Usuário" required autofocus>
            <input type="password" id="" name="passwordLogin" class="" placeholder="Senha" required>
            <input type="submit" name="submit" value="Login">
        </form>
    </body>
</html>
<?php
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('view/alerts.php');

    //Controle de acesso, só é possível acessar os.php/clientes.php com a session de logged_in.
    if(@$_SESSION['alerts'] == 'forcedEntry'){
       echo '<script> alertify.error("Acesso negado!") </script>';
        $_SESSION['alerts'] == ' ';
        @session_destroy();
    }
    
   //Aqui eu verifico se a SESSION alert = logout, se sim eu destruo a sessão assim que for redirecionado para está página. 
    if(@$alert == 'logout'){
        @session_destroy();
    }
?>
