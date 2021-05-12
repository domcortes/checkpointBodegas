<?php
require '../clases/connect.php';
    $username = !empty($_POST['user']) ? trim($_POST['user']) : null;
    $passwordAttempt = !empty($_POST['pass']) ? trim($_POST['pass']) : null;

    $sql = "SELECT contrasenna, correoElectronico, idusuario, nivelAcceso, usuarioAcceso, sucursal FROM usuarios WHERE usuarioAcceso = '$username' and activo=1;";
    $stmt = $con->prepare($sql);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //If $row is FALSE.
    if($user === 0){
        $tools=null;
        $con=null;
        header("Location: /html/wrongUser.html");
        ob_end_flush();
    } else{
        $validPassword = password_verify($passwordAttempt, $user['contrasenna']);
        if($validPassword){
            session_start();
            $_SESSION['verificar']=true;
            $_SESSION['idUsuario']=$user['idusuario'];
            $_SESSION['nivelAcceso']=$user['nivelAcceso'];
            $_SESSION['sucursal']=$user['sucursal'];

            header("Location: /panel/home.php");
            ob_end_flush();
            exit;
        } else{
            $tools=null;
            $con=null;
            header("Location: /html/wrongPassword.html");
            ob_end_flush();
            exit;
        }
    }
?>