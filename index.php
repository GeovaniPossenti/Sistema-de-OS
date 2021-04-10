<?php 
    session_start();
    include_once 'model/conexao.php';
?> 
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tools/css/style.css">
    <!--Bootstrap.-->
    <script src="tools/lib/bootstrap-5.0.0-beta3-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="tools/lib/bootstrap-5.0.0-beta3-dist/css/bootstrap.min.css">
    <!--JQuery.-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <!--Script dos alertas.-->
	<link rel="stylesheet" href="tools/lib/alertifyjs/css/alertify.min.css">
	<link rel="stylesheet" href="tools/lib/alertifyjs/css/themes/default.min.css">
	<script src="tools/lib/alertifyjs/alertify.min.js"></script>
    <title>Login</title>
</head>
<body class="fundo">
    <form class="box_form" method="post" action="control/controle_usuario.php?id=log">
        <h1>Login</h1>
        <input type="text" id="" name="emailUsuarioLog" size="" value="" placeholder="E-mail" required autofocus>
        <input type="password" id="" name="senhaUsuarioLog" class="" placeholder="Password" required>
        <input type="submit" name="submit" value="Login">
    </form>
</body>
</html>
<?php
    include_once ('view/alerts.php');

    if(@$_SESSION['alerts'] == 'forcedEntry'){
       echo '<script> alertify.error("Acesso negado!") </script>';
        $_SESSION['alerts'] == ' ';
        @session_destroy();
    }
    
   //Para acabar com as variaveis globais de usuario. 
    if(@$alert == 'logout'){
        @session_destroy();
    }


?>
