<?php
    $initialRut = $_GET['r'];
    $rutCliente = base64_decode(base64_decode(base64_decode($initialRut)));
    $initialQuote = $_GET['qn'];
    $numeroCotizacion = base64_decode(base64_decode(base64_decode($initialQuote)));

    require_once("../../panel/php/clases/Conexion.php");
    require_once("../../panel/php/clases/crudTeleventa.php");
    require_once("../../panel/php/clases/cc2.php");

    $tsql = "SELECT DISTINCT
                dbo.MAEEDO.EMPRESA AS empresa,
                dbo.MAEEDO.TIDO AS Tipo,
                dbo.MAEEDO.NUDO AS numero,
                dbo.MAEEDO.ENDO AS rut,
                dbo.MAEEN.NOKOEN AS RSocial,
                dbo.MAEEN.GIEN AS giro,
                dbo.MAEEN.CIEN AS ciudad,
                dbo.MAEEN.CMEN AS comuna,
                dbo.MAEEN.DIEN AS direccion,
                dbo.MAEEN.FOEN AS fono,
                dbo.MAEEDO.FEEMDO AS fechaE,
                dbo.MAEDDO.BOSULIDO AS Bodega,
                dbo.MAEDDO.KOPRCT AS SKU,
                dbo.MAEDDO.NOKOPR AS Descripcion,
                dbo.MAEEDO.CAPRCO AS CantidadT,
                dbo.MAEDDO.CAPRCO1 AS Cantidad,
                dbo.MAEDDO.VANELI AS NetoSKU,
                dbo.MAEDDO.VAIVLI AS IvaSKU,
                dbo.MAEDDO.VABRLI AS BrutoSKU,
                dbo.MAEEDO.VANEDO AS NetoTotal,
                dbo.MAEEDO.VAIVDO AS IvaTotal,
                dbo.MAEEDO.VABRDO AS BrutoTotal,
                dbo.MAEDDO.PODTGLLI AS porcDesc,
                dbo.MAEDDO.VADTNELI AS NetoDesc,
                dbo.MAEDDO.VADTBRLI AS BrutoDesc,
                dbo.MAEST.STFI1 AS STOCKACTUAL,
                dbo.MAEDDO.PPPRBR AS UnitBruto,
                dbo.MAEDDO.UD01PR AS UM
            FROM
                dbo.MAEEDO
            INNER JOIN
                dbo.MAEDDO ON dbo.MAEEDO.IDMAEEDO = dbo.MAEDDO.IDMAEEDO
            INNER JOIN
                dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
            INNER JOIN
                dbo.MAEST ON dbo.MAEDDO.BOSULIDO = dbo.MAEST.KOBO AND dbo.MAEDDO.KOPRCT = dbo.MAEST.KOPR
            WHERE
                (dbo.MAEEDO.TIDO = 'COV') AND (dbo.MAEEDO.ENDO = '$rutCliente') AND (dbo.MAEEDO.NUDO = '$numeroCotizacion')";

$sentencia = $con->prepare($tsql,[
  PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia->execute();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../panel/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../panel/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="">
<div class="">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>COTIZACION</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">

            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="callout callout-info">
              <?php
                      $clienteSQL = "SELECT DISTINCT
                                dbo.MAEEDO.EMPRESA AS empresa,
                                dbo.MAEEDO.TIDO AS Tipo,
                                dbo.MAEEDO.NUDO AS numero,
                                dbo.MAEEDO.ENDO AS rut,
                                dbo.MAEEN.NOKOEN AS RSocial,
                                dbo.MAEEN.EMAIL as email,
                                dbo.MAEEN.GIEN AS giro,
                                dbo.MAEEN.CIEN AS ciudad,
                                dbo.MAEEN.CMEN AS comuna,
                                dbo.MAEEN.DIEN AS direccion,
                                dbo.MAEEN.FOEN AS fono,
                                dbo.MAEEDO.FEEMDO AS fechaE,
                                dbo.MAEEDO.VANEDO AS NetoTotal,
                                dbo.MAEEDO.VAIVDO AS IvaTotal,
                                dbo.MAEEDO.VABRDO AS BrutoTotal
                              FROM dbo.MAEEDO
                              INNER JOIN dbo.MAEDDO ON dbo.MAEEDO.IDMAEEDO = dbo.MAEDDO.IDMAEEDO
                              INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
                              WHERE (dbo.MAEEDO.TIDO = 'COV') AND (dbo.MAEEDO.ENDO = '$rutCliente') AND (dbo.MAEEDO.NUDO = '$numeroCotizacion')";

                      $sentencia2 = $con->prepare($clienteSQL,[PDO::ATTR_CURSOR=>PDO::CURSOR_SCROLL]);
                      $sentencia2->execute();
                      $cliente = $sentencia2->fetch(PDO::FETCH_ASSOC);
                      $fechaEmision = strtotime(date_format($cliente['fechaE'],'d-m-Y'));
                      $fechaEmision2 = date_format($cliente['fechaE'],'d-m-Y');
                      $fechaHoy = strtotime(date('d-m-Y'));

                      $deltaDias = $fechaHoy-$fechaEmision;
                      ?>
              <h5><i class="fas fa-info"></i> Nota Importante:</h5>
              Esta cotización es válida por 5 dias a contar de la fecha de emisión.
              <?php if ($deltaDias ===5 ) {
              ?>
              <div class="alert alert-warning mt-3 text-center" role="alert">
                <strong>AVISO IMPORTANTE: </strong> Este es el ultimo dia vigente de esta cotización
                <form>
                  <input type="submit" class="btn btn-warning" name="" disabled="true" value="¡Quiero tomarla!">
                </form>
              </div>
              <?php
              } else if ($deltaDias>5) {
              ?>
                <div class="alert alert-danger mt-3" role="alert">Advertencia: Esta cotización ya venció. </div>
              <?php
              } else if ($deltaDias <5) {
              ?>
                <div class="alert alert-success mt-3 text-center" role="alert">Advertencia: Esta cotización aun está vigente.
                  <form>
                    <input type="submit" class="btn btn-success" name="" disabled="true" value="¡Quiero tomarla!">
                  </form>
                </div>
              <?php
                }
              ?>
            </div>
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
                    <i class="fas fa-globe"></i> Empresas Chelech
                    <small class="float-right"><strong>Fecha de Emisión: </strong><?php echo $fechaEmision2; ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Cliente:
                  <address>
                    <strong><?php echo $cliente['RSocial']; ?></strong><br>
                    <?php echo $cliente['direccion']; ?><br>
                    Cod.Ciudad: <?php echo $cliente['comuna']; ?><br>
                    Teléfono: <?php echo $cliente['fono']; ?><br>
                    E-Mail: <?php $cliente['email']; ?>
                  </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                  <b>Cotización: </b><?php echo $numeroCotizacion; ?><br>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th class="text-center">Cód</th>
                      <th>Detalle/Descripción</th>
                      <th class="text-center">Cant</th>
                      <th class="text-center">UM</th>
                      <th class="text-center">Unit Bruto</th>
                      <th class="text-center">Dcto</th>
                      <th class="text-center">Valor Dcto.</th>
                      <th class="text-center">Total</th>
                      <th></th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                  while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td class="text-center"><?php echo $row['SKU']; ?></td>
                      <td><?php echo $row['Descripcion']; ?></td>
                      <td class="text-center"><?php echo number_format($row['Cantidad'],'2',',','.'); ?></td>
                      <td class="text-center"><?php echo $row['UM']; ?></td>
                      <td class="text-center"><?php echo number_format($row['UnitBruto'],0,',','.'); ?></td>
                      <td class="text-center"><?php echo number_format($row['porcDesc'],2,',','.'); ?> % </td>
                      <td class="text-center"><?php echo $row['NetoDesc']; ?></td>
                      <td class="text-center"><?php echo number_format($row['BrutoSKU'],0,',','.'); ?></td>
                      <td>
                          <?php
                            if ($row['STOCKACTUAL']===5) {
                        ?>
                        <span class="right badge badge-warning">¡Últimos 5!</span>
                        <?php
                            } else if ($row['STOCKACTUAL']<5) {
                        ?>
                            <span class="right badge badge-danger">Sin stock</span>
                        <?php
                            } else {
                        ?>
                            <span class="right badge badge-success">Disponible</span>
                        <?php
                            }
                        ?>
                      </td>
                    </tr>
                <?php
                  }
                ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">
                  <p class="lead"></p>
                  <img src="../../dist/img/credit/visa.png" alt="">
                  <img src="../../dist/img/credit/mastercard.png" alt="">
                  <img src="../../dist/img/credit/american-express.png" alt="">
                  <img src="../../dist/img/credit/paypal2.png" alt="">

                  <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">

                  </p>
                </div>
                <!-- /.col -->
                <div class="col-6">
                  <p class="lead"></p>

                  <div class="table-responsive">
                    <table class="table">
                      <?php
                      $tsql3 = "SELECT DISTINCT
                                dbo.MAEEDO.EMPRESA AS empresa,
                                dbo.MAEEDO.TIDO AS Tipo,
                                dbo.MAEEDO.NUDO AS numero,
                                dbo.MAEEDO.ENDO AS rut,
                                dbo.MAEEN.NOKOEN AS RSocial,
                                dbo.MAEEN.GIEN AS giro,
                                dbo.MAEEN.CIEN AS ciudad,
                                dbo.MAEEN.CMEN AS comuna,
                                dbo.MAEEN.DIEN AS direccion,
                                dbo.MAEEN.FOEN AS fono,
                                dbo.MAEEDO.FEEMDO AS fechaE,
                                dbo.MAEEDO.VANEDO AS NetoTotal,
                                dbo.MAEEDO.VAIVDO AS IvaTotal,
                                dbo.MAEEDO.VABRDO AS BrutoTotal
                              FROM dbo.MAEEDO
                              INNER JOIN dbo.MAEDDO ON dbo.MAEEDO.IDMAEEDO = dbo.MAEDDO.IDMAEEDO
                              INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
                              WHERE (dbo.MAEEDO.TIDO = 'COV') AND (dbo.MAEEDO.ENDO = '$rutCliente') AND (dbo.MAEEDO.NUDO = '$numeroCotizacion')";

                      $sentencia3 = $con->prepare($tsql3, [PDO::ATTR_CURSOR=>PDO::CURSOR_SCROLL]);
                      $sentencia3->execute();
                      $totales = $sentencia3->fetch(PDO::FETCH_ASSOC);
                      ?>
                      <tr>
                        <th style="width:50%">Subtotal</th>
                        <td></td>
                      </tr>
                      <tr>
                        <th>T. Descuento:</th>
                        <td></td>
                      </tr>
                      <tr>
                        <th>T. Neto:</th>
                        <td><?php echo number_format(round($totales['NetoTotal'],0,PHP_ROUND_HALF_UP),0,',','.'); ?></td>
                      </tr>
                      <tr>
                        <th>I.V.A.</th>
                        <td><?php echo number_format(round($totales['IvaTotal'],0,PHP_ROUND_HALF_UP),0,',','.'); ?></td>
                      </tr>
                      <tr>
                        <th>TOTAL</th>
                        <td><?php echo number_format(round($totales['BrutoTotal'],0,PHP_ROUND_HALF_UP),0,',','.'); ?></td>
                        <?php $sentencia=null; $sentencia2=null; $sentencia3=null; $con=null; ?>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">

                </div>
              </div>
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../panel/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../panel/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../panel/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../panel/dist/js/demo.js"></script>
</body>
</html>
