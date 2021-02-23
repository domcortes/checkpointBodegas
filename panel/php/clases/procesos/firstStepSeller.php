<?php
    /*session_start();
    if(!$_SESSION['verificar']){
        header("Location: /html/notAllowed.html");
    }else {*/
      require_once "../Conexion.php";
      require_once "../crud.php";
      session_start();
      unset($_SESSION['entrada']);
      //ingreso
      $statusIngreso = "Pendiente";
      $tipoIngreso = $_POST['tipoIngreso'];
      $sellerOrigin = $_POST['sellerOrigin'];
      $documentType = "sin documento";
      $length=6;
      $docNumber = substr(str_shuffle("0123456789"), 0, $length);
      $epp = null;
      $verEpp = $_POST['epp'];
        if ($verEpp===null) {
            $epp = "no";
        } else {
            $epp = "si";
        }

      var_dump($docNumber);

      //persona
      $nameSeller = $_POST['seller'];
      $rutSeller = $_POST['rutSeller'];
      $ingresarComo = "trabajador";
      $morePeople = $_POST['companionSeller'];


      $datos = array(
            $tipoIngreso,
            $sellerOrigin,
            $documentType,
            $docNumber,
            $statusIngreso
      );

      $obj = new metodos();
      if($obj->firstStepCustomerLoader($datos)){
        $titular = new metodos();
        $checkIn= "SELECT * from ingreso where numeroDocumento=$docNumber";
        $ingresos = $titular->mostrarDatos($checkIn);
        $_SESSION['entrada']= $ingresos[0]['idIngreso'];
        $idIngresoSeller = $_SESSION['entrada'];
          $titularCompra = array(
            $idIngresoSeller,
            $nameSeller,
            $rutSeller,
            $ingresarComo,
            $epp
          );

          $obj2 = new metodos();
          if($obj2->agregarTitular($titularCompra)){
            if($morePeople!='on'){
              header("Location: ../../../../panel/home.php");
              ob_end_flush();
              exit();
            } else {
              header("Location: ../../../pages/forms/companionSeller.php");
              ob_end_flush();
              exit();
            }
          } else {
            echo "fallo al agregar titular";
          }
      } else {
          echo "fallo al agregar ingreso";
      }

?>