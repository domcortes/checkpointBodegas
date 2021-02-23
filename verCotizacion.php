<?php
ob_start();
    // $initialRut = $_GET['r'];
    // $rutCliente = base64_decode(base64_decode(base64_decode($initialRut)));
    // $initialQuote = $_GET['qn'];
    // $numeroCotizacion = base64_decode(base64_decode(base64_decode($initialQuote)));

    require_once("panel/php/clases/Conexion.php");
    require_once("panel/php/clases/cc2.php");
    require_once("panel/php/clases/crudTeleventa.php");

    $nsql = "SELECT dbo.MAEEDO.EMPRESA AS empresa,
                    dbo.MAEEDO.TIDO AS Tipo,
                    dbo.MAEEDO.NUDO AS numero,
                    dbo.MAEEDO.ENDO AS rut,
                    dbo.MAEEN.NOKOEN AS RSocial,
                    dbo.MAEEN.GIEN AS giro, dbo.MAEEN.CIEN AS ciudad,
                    dbo.MAEEN.CMEN AS comuna,
                    dbo.MAEEN.DIEN AS direccion,
                    dbo.MAEEN.FOEN AS fono,
                    dbo.MAEEDO.FEEMDO AS fechaE,
                    dbo.MAEDDO.BOSULIDO AS Bodega,
                    dbo.MAEDDO.KOPRCT AS SKU,
                    dbo.MAEDDO.NOKOPR AS Descripcion,
                    dbo.MAEEDO.CAPRCO AS CantidadT,
                    dbo.MAEDDO.CAPRCO1 AS Cantidad,
                    dbo.MAEDDO.PPPRBR AS UnitBruto,
                    dbo.MAEDDO.UD01PR AS UM,
                    dbo.MAEDDO.VANELI AS NetoSKU,
                    dbo.MAEDDO.VAIVLI AS IvaSKU,
                    dbo.MAEDDO.VABRLI AS BrutoSKU,
                    dbo.MAEEDO.VANEDO AS NetoTotal,
                    dbo.MAEEDO.VAIVDO AS IvaTotal,
                    dbo.MAEEDO.VABRDO AS BrutoTotal,
                    dbo.MAEDDO.PODTGLLI AS porcDesc,
                    dbo.MAEDDO.VADTNELI AS NetoDesc,
                    dbo.MAEDDO.VADTBRLI AS BrutoDesc
            FROM dbo.MAEEDO
            INNER JOIN
                    dbo.MAEDDO ON dbo.MAEEDO.IDMAEEDO = dbo.MAEDDO.IDMAEEDO
            INNER JOIN
                    dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN";
    $sentencia = $con->prepare($nsql,[
                        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
                      ]);
    $sentencia->execute();

    while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
        echo '<pre>';
        var_dump($row);
        echo '</pre>';
    }
    $sentencia=null;
    $con=null;
?>