<?php
    /*session_start();
    if(!$_SESSION['verificar']){
        header("Location: /html/notAllowed.html");
    }else {

    }*/


    require_once "../Conexion.php";
        require_once "../crud.php";

        $usuario = $_POST['userSelected'];
        $empresa = $_POST['companySelected'];



        $datos = array(
            $usuario,
            $empresa
        );

        $obj = new metodos();
        if($obj->agregarEmpresaAUsuario($datos)){
            header("Location: ../../../pages/forms/actualizarUsuario.php?idUsuario=$usuario");
            ob_end_flush();
            exit();
        }else {
            echo "fallo al agregar <a href='/panel/home.php'>Volver al home</a>";
            exit();
        }
?>