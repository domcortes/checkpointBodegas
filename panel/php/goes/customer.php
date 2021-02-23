<?php
    require '../clases/connect.php';

    $usercode = !empty($_POST['rutSDV']) ? trim($_POST['rutSDV']) : null;
    /* $sql = "SELECT contrasenna, correoElectronico, idusuario, nivelAcceso, usuarioAcceso FROM usuarios WHERE usuarioAcceso = '$username';";
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
    */

    session_start();
    $_SESSION['verificar'] = true;
    $_SESSION['rutClienteSDV'] = $usercode;
    header("Location: /accesoClientes/checkIn/index.php");
    ob_end_flush();
    exit;



?>


?>