<?php

require '../connect.php';

    $nombreUsuario = !empty($_POST['nombreUsuario']) ? trim($_POST['nombreUsuario']) : null;
    $contrasenna = !empty($_POST['contrasenna']) ? trim($_POST['contrasenna']) : null;

    $sql = "SELECT nombreUsuario, contrasenna, nivelAcceso FROM usuarios WHERE nombreUsuario = '$nombreUsuario';";
    $stmt = $con->prepare($sql);

    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    //If $row is FALSE.
    if($user === false){
        $tools=null;
        $con=null;
        echo 'usuario no existe';
        //header("Location: /html/wrongUser.html");
        ob_end_flush();
    } else{

        $validPassword = password_verify($contrasenna, $user['contrasenna']);
        
        if($validPassword){
            session_start();
            $_SESSION['verificar']=true;
            $_SESSION['nombreUsuario']=$user['nombreUsuario'];
            $_SESSION['acceso']=$user['nivelAcceso'];
            
            if($_SESSION['acceso']==='administrador'){
                  header("Location: ../../usuarios.php");
                  ob_end_flush();
                  exit;
            }else{
                  header("Location: ../../ingresoProductos.php");
                  ob_end_flush();
                  exit;
            }
            
        } else{

            var_dump($user);
            $tools=null;
            $con=null;
            //header("Location: /html/wrongPassword.html");
            echo ' contraseña incorrecta';
            ob_end_flush();
            exit;
        }
    }