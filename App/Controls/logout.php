<?php
    session_start();
    // muda o valor de logged_in para false
    $_SESSION['logged_in'] = false;
    $_SESSION['alerts'] = 'logout';
    // retorna para a index.php
    header('Location: ../../index.php');
?>