<?php
    session_start();
    if(!$_SESSION['verificar']){
        header("Location: /html/notAllowed.html");
    }else {
        require_once "../Conexion.php";
        require_once "../crud.php";

        $nombreAcompanante = $_POST['companionCustomer'];
        $rutAcompanante = $_POST['rutCompanion'];
        $tipoIngreso = "acompañante";
        $verEpp = $_POST['epp'];
        if ($verEpp===null) {
            $epp = "no";
        } else {
            $epp = "si";
        }

        $datos = array(
            $_SESSION['entrada'],
            $nombreAcompanante,
            $rutAcompanante,
            $tipoIngreso,
            $epp
        );

        $obj = new metodos();
        if($obj->addCompanion($datos)){
            header("Location: ../../../pages/forms/companion.php");
            ob_end_flush();
            exit();
        }else {
            echo "fallo al agregar";
        }
    }
?>