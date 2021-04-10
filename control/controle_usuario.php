<?php 
    @session_start();

    include_once '../model/conexao.php';
    $conn = new Conexao;
    $con = $conn->conectar();

    //Var passada pelo url.
    @$op = $_GET['op'];

    //Login de usuario.
    if ($op == 'log'){
        $login = isset($_POST['emailUsuarioLog']) ? $_POST['emailUsuarioLog'] : '';
        $password = isset($_POST['senhaUsuarioLog']) ? $_POST['senhaUsuarioLog'] : '';

        //Aqui ele faz a senha em formato md5
        //$passwordHash = make_hash($password);

        $sql = "SELECT `nome_usuario`, `email_usuario` FROM `usuario` WHERE BINARY email_usuario = ? AND BINARY senha_usuario = ?";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(1, $login);
        $stmt->bindParam(2, $password);
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

            header("location: ../view/os.php");

            //Session com os dados e variaveis necessárias.
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $user['id_usuario'];
            $_SESSION['alerts'] = 'logOk';
        }
    }
?>