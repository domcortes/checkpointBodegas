<?php

    require_once("../Conexion.php");
    require_once("../crud.php");
    $idCompra = $_GET['idCompra'];
    $status = "Procesando";

      $updating = array(
        $status,
        $idCompra
      );

      $actualizar = new metodos();
      $actualizar->marcarProcesar($updating);
      header("Location: ../../../pages/tables/ingresos.php");
      ob_end_flush();
      exit();
?>