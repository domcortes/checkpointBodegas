<?php
    session_start();
    if(!$_SESSION['verificar']){
        header("Location: /html/notAllowed.html");
    }else {
        require_once "../Conexion.php";
        require_once "../crud.php";

        $idCategoria = mysqli_real_escape_string($_POST['idCategoria']);
        $nombreClaseEspanol = $_POST['nombreCategoriaEspanol'];
        $nombreClaseIngles = $_POST['nombreCategoriaIngles'];

        $datos = array(
              $idCategoria,
              $nombreClaseEspanol,
              $nombreClaseIngles
        );

        $obj = new metodos();
        if($obj->actualizarCategoria($datos)){
            header("Location: ../../ingresoCategoria.php");
            ob_end_flush();
            exit();
        }else {
            echo "fallo al actualizar";
        }
    }
?>