<?php
    require_once('clases/cc2.php');
    $valeTransitorio=$_POST['valeTransitorio'];

   if($valeTransitorio==null){
    echo "<label>Monto</label>
            <input type='number' name='amount' id='amount' class='form-control' placeholder='Monto' disabled='true' required>";
    } else {
        $sql="SELECT * FROM MAEEDO WHERE NUDO = '$valeTransitorio'";
        $consultar = $con->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
        $consultar->execute();
        $cantDocumentos = 0;
        while ($row = $consultar->fetch(PDO::FETCH_ASSOC)) {
            $cantDocumentos++;
        }
        if($cantDocumentos===0){
            $cadena="<label>Monto</label><input type='text' name='amount' id='amount' class='form-control' placeholder='No existe valor asociado' disabled='true'>";
            echo $cadena;
        } else {
            $consultar = $con->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL]);
            $consultar->execute();
            $getAmount = $consultar->fetch(PDO::FETCH_ASSOC);
            $monto = number_format($getAmount['VABRDO'],0,",",".")*1000;
            $cadena="<label>Monto</label><input type='number' name='amount' id='amount' class='form-control' placeholder='Monto' value='".$monto."'required>";
            echo $cadena;
        }
        $consultar=null;
        $con=null;
   }
 ?>