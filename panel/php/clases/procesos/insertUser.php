<?php
    /*session_start();
    if(!$_SESSION['verificar']){
        header("Location: /html/notAllowed.html");
    }else {

    }*/


    require_once "../Conexion.php";
        require_once "../crud.php";

        $nombreUsuario = $_POST['nombreUsuario'];
        $contrasenna = $_POST['contrasenna'];
        $cryptPass = password_hash($contrasenna,PASSWORD_BCRYPT,array("cost"=>12));
        $rutUsuario = $_POST['rutUsuario'];
        $usuarioAcceso = $_POST['usuarioAcceso'];
        $correoElectronico=$_POST['correoElectronico'];
        $nivelAcceso=$_POST['nivelAcceso'];
        $sucursal = $_POST['sucursal'];


        $datos = array(
              $rutUsuario,
              $nombreUsuario,
              $usuarioAcceso,
              $nivelAcceso,
              $correoElectronico,
              $cryptPass,
              $sucursal
        );

        $obj = new metodos();
        if($obj->agregarUsuario($datos)){
            header("Location: ../../../php/usuarios.php");
            ob_end_flush();
            exit();
        }else {
            echo "fallo al agregar";
        }
?>