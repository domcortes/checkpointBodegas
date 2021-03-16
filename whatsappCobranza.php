<?php

require('pdf/fpdf.php');
require_once('panel/php/clases/cc2.php');
$rutCliente=$_POST['idCliente'];

    if (isset($_POST['telefonoContacto'])) {
        $telCliente = $_POST['telefonoContacto'];
        if (strlen($telCliente)==8) {
            $startDateSQL = $_POST['dateStart'];
            $endDateSQL = $_POST['dateEnd'];
            $dateStart = substr($startDateSQL, 6, 2).'-'.substr($startDateSQL, 4, 2).'-'.substr($startDateSQL, 0, 4);
            $dateEnd = substr($endDateSQL, 6, 2).'-'.substr($endDateSQL, 4, 2).'-'.substr($endDateSQL, 0, 4);
            $dateFileNameIn = substr($startDateSQL, 6, 2).'_'.substr($startDateSQL, 4, 2).'_'.substr($startDateSQL, 0, 4);
            $dateFileNameOut = substr($endDateSQL, 6, 2).'_'.substr($endDateSQL, 4, 2).'_'.substr($endDateSQL, 0, 4);

            $nsql= "SELECT DISTINCT
                          TOP (100) PERCENT
                            dbo.MAEEN.NOKOEN AS RSocial,
                            dbo.MAEEN.DIEN AS Direccion,
                            dbo.MAEEN.FOEN AS Telefono,
                            dbo.MAEEN.KOEN AS Rut,
                            dbo.MAEEN.EMAIL AS Email,
                            dbo.MAEEDO.TIDO AS Tipo,
                            dbo.MAEEDO.NUDO AS Numero,
                            dbo.MAEEDO.FEEMDO AS Fecha,
                            dbo.MAEVEN.FEVE AS FVencimiento,
                            dbo.MAEEDO.ESPGDO AS Estado,
                            datediff(day,dbo.MAEEDO.FEEMDO,dbo.MAEVEN.FEVE) AS DIAS,
                            dbo.MAEVEN.ESPGVE, dbo.MAEEDO.VABRDO AS valorCompra,
                            dbo.MAEVEN.VAVE AS VCuota,
                            dbo.MAEVEN.VAABVE AS Abono,
                            dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS PorPagar
                        FROM dbo.MAEEDO
                        INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN AND dbo.MAEEDO.SUENDO = dbo.MAEEN.SUEN
                        RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
                        WHERE (dbo.MAEEDO.TIDO IN ('FCV', 'BLV', 'RIN'))
                          AND (dbo.MAEVEN.ESPGVE <> 'C')
                          AND (dbo.MAEVEN.FEVE BETWEEN '$startDateSQL' AND '$endDateSQL')
                          AND dbo.MAEEDO.ENDO='$rutCliente'
                        ORDER BY Rut, Numero,FVencimiento";
            $sentencia = $con->prepare($nsql,[
                PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
            ]);
            $sentencia->execute();
            $totalMes = 0;
            while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                $totalMes = $totalMes+$row['PorPagar'];
            }

            $valor = $totalMes;
            //Configuración del algoritmo de encriptación

            $clave  = '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$';
            $method = 'aes-256-cbc';
            $iv = base64_decode("C9fBxl1EWtYTL1/M8jfstw==");

             /*
             Encripta el contenido de la variable, enviada como parametro.
              */
             $encriptar = openssl_encrypt ($valor, $method, $clave, false, $iv);
             $rutEncriptado = openssl_encrypt($rutCliente, $method, $clave, false, $iv);
             $in = openssl_encrypt($dateStart, $method, $clave, false, $iv);
             $out = openssl_encrypt($dateEnd, $method, $clave, false, $iv);
            echo
                "<script>
                    var clienteLink = 'https://www.chelech.cl/caja.php?a=".$encriptar."&r=".$rutEncriptado."&i=".$in."&o=".$out."';
                    var telCliente = '".$telCliente."';
                    console.log(telCliente);
                    window.open('https://api.whatsapp.com/send?phone=569'+ telCliente +'+&text=Estimado%20cliente,%20a%20continuación%20encontrará%20el%20link%20para%20pago%20online,%20recuerde%20tener%20a%20mano%20sus%20medios%20de%20verificacion,%20ya%20sea%20tercera%20clave%20o%20tarjeta%20de%20coordenadas%20respectivas:%20' + encodeURIComponent(clienteLink));
                    history.back();
                </script>";
            // header('Location: /panel/pages/tables/cobranzasCompleto.php');
        } else {
            echo "<script>
                    alert('El numero de whatsapp no es valido, no debe incluir el 9 inicial o el largo del celular no debe ser mayor a 8 digitos. Si usted ingreso el numero a esta intranet, corrijalo. Si el resultado viene desde RANDOM, modifique los caracteres a 8 para ejecutar esta accion.');
                    history.back();
                </script>";
        }
    }

?>
