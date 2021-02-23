<?php
  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    require_once("../../clases/Conexion.php");
    require_once("../../clases/cc2.php");

    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    unset($_SESSION['entrada']);


    $numeroCotizacion = $_POST['numeroCotizacion'];
    $rutCliente = $_POST['rut'];


    $tsql= "SELECT * FROM dbo.MAEEDO WHERE TIDO ='COV' AND NUDO ='$numeroCotizacion'";
    $cq = $con->prepare($tsql,[
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
    ]);
    $cq->execute();


    /*
    $getResults= sqlsrv_query($conn, $tsql);
    if ($getResults == FALSE)
    	die(FormatErrors(sqlsrv_errors()));
*/
    $cantElementos = 0;
    while ($gq = $cq->fetch(PDO::FETCH_ASSOC)) {
    	$cantElementos++;
    }

    if ($cantElementos===0) {
    	echo '<script>
    				alert("No se han encontrado cotizaciones con la serie '.$numeroCotizacion.' asociado al rut '.$rutCliente.'. Reintente con otro código o rut de cliente");
    				window.location="/panel/pages/forms/startProcess.php";
    		  </script>';
    	ob_end_flush();
    	exit;
    } else {
    	$cotizacionEncontrada = base64_encode(base64_encode(base64_encode($numeroCotizacion)));
    	$rutEncontrado = base64_encode(base64_encode(base64_encode($rutCliente)));
    	header('Location: /panel/pages/tables/televenta/quote.php?qn='.$cotizacionEncontrada.'&r='.$rutEncontrado);
    	ob_end_flush();
    	exit;
    }
  }


?>