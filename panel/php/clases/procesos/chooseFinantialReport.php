<?php
  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    require_once ("../Conexion.php");
    require_once ("../crud.php");
    $reporte = $_POST['inform'];
    $rut = $_POST['rut'];

    if ($rut==='') {
      if ($reporte==='tcc') {
        header('Location: /panel/pages/tables/testCuotasCompletos.php');
        ob_end_flush();
        exit();
      } else {
        header('Location: /panel/pages/forms/checkPendingDocs.php');
        ob_end_flush();
        exit();
      }
    } else {
      $hashRut = base64_encode($rut);
      if ($reporte==='pd') {
        header('Location: /panel/pages/tables/consultaDocumentos.php?i='.$hashRut);
        ob_end_flush();
        exit();
      } else if ($reporte==='pc'){
        header('Location: /panel/pages/tables/consultaCuotasPendientes.php?i='.$hashRut);
        ob_end_flush();
        exit();
      } else if ($reporte==='mc'){
        header('Location: /panel/pages/tables/consultaCuotaMes.php?i='.$hashRut);
        ob_end_flush();
        exit();
      } else if ($reporte==='icc'){
        header('Location: /panel/pages/tables/cobranzasCompleto.php');
        ob_end_flush();
        exit();
      }
    }

  }




?>