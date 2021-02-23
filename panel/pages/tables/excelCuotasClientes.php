<?php
if ($_GET['in']!=null && $_GET['out']!=null) {
      require_once("../../php/clases/Conexion.php");
      require_once("../../php/clases/cc2.php");
      $salidafechaIn = $_GET['in'];
      $salidafechaOut = $_GET['out'];
      $fechaEmision = new DateTime('NOW');
      $in = substr($salidafechaIn,6,2).'_'.substr($salidafechaIn, 4,2).'_'.substr($salidafechaIn, 0,4);
      $out = substr($salidafechaOut,6,2).'_'.substr($salidafechaOut, 4,2).'_'.substr($salidafechaOut, 0,4);
      header("Pragma: public");
      header("Expires:0");
      $filename="Cuotas Pendientes Completo periodo ".$in." - ".$out." emision ".$fechaEmision->format('d_m_Y H_i_s').".xls";
      header("Content-type: application/x-msdownload");
      header("Content-Disposition: attachment; filename=$filename");
      header("Pragma: no-cache");
      header("Cache-control: must-revalidate, post-check=0, pre-check=0");
      $nsql= "SELECT DISTINCT
                    TOP (100) PERCENT dbo.MAEEN.NOKOEN AS RSocial,
                    dbo.MAEEN.DIEN AS Direccion,
                    dbo.MAEEN.FOEN AS Telefono,
                    dbo.MAEEN.KOEN AS Rut,
                    dbo.MAEEN.EMAIL AS Email,
                    dbo.MAEEDO.TIDO AS Tipo,
                    dbo.MAEEDO.NUDO AS Numero,
                    dbo.MAEEDO.FEEMDO AS Fecha,
                    dbo.MAEEDO.ESPGDO AS Estado,
                    dbo.MAEVEN.FEVE AS FVencimiento,
                    dbo.MAEVEN.ESPGVE, dbo.MAEEDO.VABRDO AS valorCompra,
                    dbo.MAEVEN.VAVE AS VCuota,
                    dbo.MAEVEN.VAABVE AS Abono,
                    dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS valorCuotaPagar
              FROM dbo.MAEEDO
              INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN AND dbo.MAEEDO.SUENDO = dbo.MAEEN.SUEN
              RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
              WHERE (dbo.MAEEDO.TIDO IN ('FCV', 'BLV', 'RIN'))
                AND (dbo.MAEVEN.ESPGVE <> 'C')
                AND (dbo.MAEVEN.FEVE BETWEEN '$salidafechaIn' AND '$salidafechaOut')
              ORDER BY Rut, FVencimiento";
} else {
  echo "<script>alert('No existen parametros suficientes para procesar el excel. Re - intente');</script>";
  echo "<script>window.location('/panel/pages/tables/cobranzasCompleto.php');</script>";
}
?>

      <table>
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Tipo</th>
                      <th>Numero</th>
                      <th>Rut</th>
                      <th>RSocial</th>
                      <th>Direccion</th>
                      <th>Telefono</th>
                      <th>Email</th>
                      <th>Fecha</th>
                      <th>Estado</th>
                      <th>FVencimiento</th>
                      <th>Valor Compra</th>
                      <th>Valor Cuota</th>
                      <th>Abono</th>
                      <th>Saldo a pagar</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $nfila = 1;
                      $sentencia = $con->prepare($nsql,[
                        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
                      ]);
                      $sentencia->execute();
                      while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                        $fecha = new DateTime($row['Fecha']);
                        $fechaFinal = $fecha->format('d/m/Y');
                        $fechaVencimiento = new DateTime($row['FVencimiento']);
                        $fechaFinalVencimiento = $fechaVencimiento->format('d/m/Y');
                    ?>
                      <tr>
                        <td><?php echo $nfila; ?></td>
                        <td><?php echo ($row['Tipo'].PHP_EOL); ?></td>
                        <td><?php echo ($row['Numero'] . PHP_EOL); ?></td>
                        <td><?php echo $row['Rut'] ?></td>
                        <td><?php echo $row['RSocial'] ?></td>
                        <td><?php echo $row['Direccion']?></td>
                        <td><?php echo $row['Telefono']?></td>
                        <td><?php echo $row['Email']?></td>
                        <td><?php echo $fechaFinal;?></td>
                        <td><?php echo $row['Estado'] ?></td>
                        <td><?php echo $fechaFinalVencimiento;?></td>
                        <td><?php echo number_format($row['valorCompra'],0,',','.') ?></td>
                        <td><?php echo number_format($row['VCuota'],0,',','.') ?></td>
                        <td><?php echo number_format($row['Abono'],0,',','.') ?></td>
                        <td><?php echo number_format($row['valorCuotaPagar'],0,',','.') ?></td>
                      </tr>
                      <?php
                        $nfila++;
                        } $sentencia=null; $con=null;
                      ?>
                  </tbody>
                </table>