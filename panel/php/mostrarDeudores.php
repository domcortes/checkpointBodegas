<?php
      require_once("clases/Conexion.php");
      require_once("clases/cc2.php");
      require_once("clases/crud.php");

    if (isset($_POST['fechaIn'])) {
        $fechaIn = $_POST['fechaIn'];
        $ddfechaIn = substr($fechaIn,0,2);
        $mmfechaIn = substr($fechaIn,3,2);
        $aaaafechaIn = substr($fechaIn,6,4);
        $salidafechaIn = $aaaafechaIn.$mmfechaIn.$ddfechaIn;
    } else {
        $fechaIn = null;
    }

    if (isset($_POST['fechaOut'])) {
        $fechaOut = $_POST['fechaOut'];
        $ddfechaOut = substr($fechaOut,0,2);
        $mmfechaOut = substr($fechaOut,3,2);
        $aaaafechaOut = substr($fechaOut,6,4);
        $salidafechaOut = $aaaafechaOut.$mmfechaOut.$ddfechaOut;
    } else {
        $fechaOut = null;
    }

    if (isset($_POST['tipoFiltro'])) {
        $tipoFiltro = $_POST['tipoFiltro'];
    } else {
        $tipoFiltro = null;
    }
    $output = '';

    $nsql= "SELECT DISTINCT
            dbo.MAEEN.IDMAEEN AS IdCliente,
            dbo.MAEEN.NOKOEN AS RSocial,
            dbo.MAEEN.DIEN AS Direccion,
            dbo.MAEEN.FOEN AS Telefono,
            dbo.MAEEN.KOEN AS Rut,
            dbo.MAEEN.EMAIL AS Email,
            dbo.MAEEDO.TIDO AS Tipo,
            dbo.MAEEDO.NUDO AS Numero,
            dbo.MAEEDO.FEEMDO AS Fecha,
            dbo.MAEEDO.ESPGDO AS Estado,
            dbo.MAEVEN.FEVE AS FVencimiento,
            dbo.MAEVEN.ESPGVE, dbo.MAEEDO.VABRDO AS Bruto,
            dbo.MAEVEN.VAABVE AS Abono,
            dbo.MAEVEN.VAVE AS VCuota,
            dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS SALDO
          FROM dbo.MAEEDO
            INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
            RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
          WHERE (dbo.MAEEDO.TIDO IN ('FCV', 'BLV','RIN')) -- AND (dbo.MAEEDO.ESPGDO = 'P')
            -- AND (dbo.MAEVEN.ESPGVE <> 'C')
            AND (dbo.MAEVEN.FEVE BETWEEN '$salidafechaIn' AND '$salidafechaOut')
            --AND (dbo.MAEEDO.ENDO = '')
          ORDER BY dbo.MAEVEN.FEVE ASC";
    $sentencia = $con->prepare($nsql,[
        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
    ]);
    $sentencia->execute();

    if (sizeof($sentencia->fetch(PDO::FETCH_ASSOC))>0) {
        while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
            $fecha = new DateTime($row['Fecha']);
            $fechaVencimiento = new DateTime($row['FVencimiento']);
            $output .= '
                <tr>
                    <td>'.$row['Tipo'].'</td>
                    <td>'.$row['Numero'].'</td>
                    <td>'.$row['Rut'].'</td>
                    <td>'.$row['RSocial'].'</td>
                    <td>'.$row['Direccion'].'</td>
                    <td>'.$row['Telefono'].'</td>
                    <td>'.$row['Email'].'</td>
                    <td>'.$fecha->format("d/m/Y").'</td>
                    <td>'.$fechaVencimiento->format("d/m/Y").'</td>
                    <td> $ '.number_format($row['Estado'],0,",",".").'</td>
                    <td> $ '.number_format($row['Bruto'],0,",",".").'</td>
                    <td> $ '.number_format($row['VCuota'],0,",",".").'</td>
                    <td> $ '.number_format($row['Abono'],0,",",".").'</td>
                    <td> $ '.number_format($row['SALDO'],0,",",".").'</td>
                </tr>
            ';
        }
    } else {
        $output .= '<tr><td colspan="9">No hay registros con estos criterios</tr>';
    }
    echo $output;

    $sentencia = null;
    $con = null;
?>