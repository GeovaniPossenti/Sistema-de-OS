<?php 
    @session_start();

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Var passada pelo url.
    @$op = $_GET['op'];

    //Login de usuario.
    if ($op == 'log'){
        $username = isset($_POST['usernameLogin']) ? $_POST['usernameLogin'] : '';
        $password = isset($_POST['passwordLogin']) ? $_POST['passwordLogin'] : '';

        //Aqui ele faz a senha em formato md5
        $passwordMd5 = make_hash($password);

        $sql = "SELECT `id_usuario`, `login_usuario`, `senha_usuario` FROM `usuarios` WHERE BINARY login_usuario = ? AND BINARY senha_usuario = ?";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(1, $username);
        $stmt->bindParam(2, $passwordMd5);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //Faz a contagem pra ver se aquele login existe no banco.
        if (count($users) <= 0){
            //Se ele não existir
            header("location: ../index.php");
            $_SESSION['alerts'] = 'logFail';
        }elseif(count($users) > 0){
            //Se ele existir
            //Pega o primeiro usuário do array.
            $user = $users[0];

            //Session com os dados e variaveis necessárias.
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['alerts'] = 'logOk';
            
            header("location: ../view/os.php");


        }
    }
?>