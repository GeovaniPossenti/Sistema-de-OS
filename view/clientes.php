<?php 
    session_start();
    include_once '../model/conexao.php';

    $login = $_SESSION['logged_in'];
    $user_id = $_SESSION['user_id']; 

    if($login != true){
        $_SESSION['alerts'] = 'forcedEntry';
        header('Location: ../index.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
</head>
<body>
    
</body>
</html>
<?php
    include_once ('../view/alerts.php');
?>