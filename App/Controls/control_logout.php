<?php
    session_start();
    $_SESSION['logged_in'] = false;
    $_SESSION['alerts'] = 'logout';
    header('Location: ../../index.php');
?>