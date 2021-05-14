<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Matrix</title>
        <!-- Logo da página. -->
        <link rel="shorcut icon" href="Source/img/computador-pessoal.png">
        <!--JQuery.-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
        <!--Script dos alertas.-->
        <link rel="stylesheet" href="Source/lib/alertifyjs/css/alertify.min.css">
        <link rel="stylesheet" href="Source/lib/alertifyjs/css/themes/default.min.css">
        <script src="Source/lib/alertifyjs/alertify.min.js"></script>
        <!-- Fonte da CDN do Google -->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300&display=swap" rel="stylesheet">
        <!--CSS da página. -->
        <link rel="stylesheet" href="Source/css/styleIndex.css">
    </head>
    <body class="fundo">
        <form class="box_form" method="post" action="App/Controls/control_user.php?op=log">
            <h1>Login</h1>
            <input type="text" id="" name="usernameLogin" size="" value="" placeholder="Usuário" required autofocus>
            <input type="password" id="" name="passwordLogin" class="" placeholder="Senha" required>
            <input type="submit" name="submit" value="Login">
        </form>
    </body>
</html>
<?php
    session_start();
    //Include da .php onde ficam as funcões de alertas, precisa ser incluido no final da página. 
    include_once ('Views/alerts.php');

    //Controle de acesso, só é possível acessar os.php/clientes.php com a session de logged_in.
    if(@$_SESSION['alerts'] == 'forcedEntry'){
       echo '<script> alertify.error("Acesso negado!") </script>';
        $_SESSION['alerts'] == ' ';
        session_destroy();
    }
    
   //Aqui eu verifico se a SESSION alert = logout, se sim eu destruo a sessão assim que for redirecionado para está página. 
    if(@$alert == 'logout'){
        session_destroy();
    }
?>
