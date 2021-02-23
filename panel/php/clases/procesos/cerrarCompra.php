<?php

    require_once("../Conexion.php");
    require_once("../crud.php");
    $idCompra = $_GET['idCompra'];
    $status = "Entregado";

      $updating = array(
        $status,
        $idCompra
      );

      $actualizar = new metodos();
      $actualizar->cerrarCompra($updating);
      header("Location: ../../../pages/tables/ingresos.php");
      ob_end_flush();
      exit();
?>