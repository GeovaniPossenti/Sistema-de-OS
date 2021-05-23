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
            <input type="text" name="usernameLogin" placeholder="Usuário" required autofocus>
            <input type="password" name="passwordLogin" placeholder="Senha" required>
            <input type="submit" name="submit" value="Login">
        </form>
    </body>
</html>
<?php
    session_start();

    include_once ('Views/alerts.php');

    if(@$_SESSION['alerts'] == 'forcedEntry'){
       echo '<script> alert10(); </script>';
        $_SESSION['alerts'] = ' ';
        session_destroy();
    }

    if(@$_SESSION['alerts'] == 'logout'){
        unset($_SESSION['logged_in']);
        unset($_SESSION['alerts']);
        session_destroy();
    }
?>
