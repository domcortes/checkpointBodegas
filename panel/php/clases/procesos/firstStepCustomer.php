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
      $customerOrigin = $_POST['customerOrigin'];
      $documentType = $_POST['documentType'];
      $docNumber = $_POST['docNumber'];

      //persona
      $nombreTitular = $_POST['customer'];
      $rutTitular = $_POST['rutTitular'];
      $ingresarComo = "titularCompra";
      $morePeople = $_POST['acompanantes'];
      $epp = null;
      $verEpp = $_POST['epp'];
        if ($verEpp===null) {
            $epp = "no";
        } else {
            $epp = "si";
        }

      $datos = array(
            $tipoIngreso,
            $customerOrigin,
            $documentType,
            $docNumber,
            $statusIngreso
      );

      $obj = new metodos();
      if($obj->firstStepCustomerLoader($datos)){
        $titular = new metodos();
        $checkIn= "SELECT * from ingreso where numeroDocumento=$docNumber";
        $ingresos = $titular->mostrarDatos($checkIn);
        $_SESSION['entrada'] = $ingresos[0]['idIngreso'];

          $titularCompra = array(
            $_SESSION['entrada'],
            $nombreTitular,
            $rutTitular,
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
              header("Location: ../../../pages/forms/companion.php");
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