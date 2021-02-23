<?php
session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $server = $_SERVER['REMOTE_ADDR'];
    $initialRut = $_GET['r'];
    $initialQuote = $_GET['qn'];
    $rutCliente = base64_decode(base64_decode(base64_decode($initialRut)));
    $numeroCotizacion = base64_decode(base64_decode(base64_decode($initialQuote)));

    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    require_once("../../../php/clases/Conexion.php");
    require_once("../../../php/clases/cc2.php");
    require_once("../../../php/clases/crudTeleventa.php");
    require_once("../../../php/clases/crud.php");

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
                dbo.MAEEN.EMAIL AS email,
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
                (dbo.MAEEDO.TIDO = 'COV') AND (dbo.MAEEDO.NUDO = '$numeroCotizacion')";
    $sentencia = $con->prepare($tsql,[
      PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
    ]);
    $sentencia->execute();
  }
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
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>


    <!-- Right navbar links -->

  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/panel/home.php" class="brand-link">
      <img src="/panel/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Chelech Net</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php $obj = new metodos();
            $sql = "select nombreUsuario from usuarios where idusuario=$idUsuario";
            $resultName = $obj->mostrarDatos($sql);
            foreach($resultName as $name){
              echo "Bienvenido ".ucwords($name['nombreUsuario']);
            }
          ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <?php if ($rolUsuario==='administrador'): ?>
            <!--bodegas-->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-archive"></i>
                  <p>
                    BODEGAS
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/panel/pages/forms/addCustomer.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Agregar compradores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/panel/pages/forms/addSeller.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Agregar trabajadores</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/panel/pages/forms/addSupplier.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Agregar abastecimientos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="/panel/pages/tables/ingresos.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de Ingresos</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/fin bodega-->
              <!--finanzas-->
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-money-bill"></i>
                  <p>
                    FINANZAS
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/panel/pages/forms/checkPendingDocs.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Realizar Consultas</p>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/fin finanzas-->
          <?php endif ?>
          <!--televenta-->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-credit-card"></i>
              <p>
                TELEVENTA
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/panel/pages/forms/startProcess.php" class="nav-link">
                  <i class="fas fa-play-circle nav-icon"></i>
                  <p>Iniciar proceso</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/panel/pages/tables/televenta/listadoLinks.php" class="nav-link">
                  <i class="fas fa-clipboard-list nav-icon"></i>
                  <p>Listado Transacciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/panel/pages/forms/boton.php" class="nav-link">
                  <i class="fas fa-share-square nav-icon"></i>
                  <p>Generar botón de pago</p>
                </a>
              </li>
            </ul>
          </li>
          <!--/fin televenta-->

          <!--acciones de sesion-->
          <li class="nav-header">DOCUMENTACION Y MANUALES</li>
          <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-archive"></i>
                  <p>
                    Sección Televenta
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                 <li class="nav-item">
                    <a href="/documents/manual/botonPago.pdf" class="nav-link" target="_blank">
                      <i class="nav-icon far fa-circle text-info"></i>
                      <p class="text">BOTON DE PAGO</p>
                    </a>
                  </li>
                </ul>
              </li>
          <li class="nav-header">ACCIONES DE SESIÓN</li>
          <li class="nav-item">
            <a href="/panel/pages/forms/editarUsuario.php" class="nav-link">
              <i class="nav-icon far fa-circle text-info"></i>
              <p>Editar Usuario</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="/panel/php/goes/logout.php" class="nav-link">
              <i class="nav-icon far fa-circle text-danger"></i>
              <p class="text">Cerrar sesión</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>COTIZACION</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item btn btn-info"><a href="/panel/pages/forms/startProcess.php" style="color:white;">Buscar otra cotización</a></li>
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
                // obtener vigencia de cotizacion
                $encabezado = $sentencia->fetch(PDO::FETCH_ASSOC);
                $fechaEmision = new DateTime($encabezado['fechaE']);
                $fechaHoy = new DateTime("NOW");
                $deltaDias = date_diff($fechaHoy,$fechaEmision);
                $deltaDias = $deltaDias->format('%d');

              ?>
              <h5><i class="fas fa-info"></i> Nota Importante:</h5>
              Esta cotización es válida por 5 dias a contar de la fecha de emisión.
              <?php if ($deltaDias ===5 ) {
                echo '<div class="alert alert-warning mt-3" role="alert">Advertencia: Este es el último día de vigencia para esta cotización. </div>';
                echo '<div class="alert alert-primary mt-3" role="alert">Link de Cliente: accesoClientes/checkIn/verCotizacion.php?qn='.$initialQuote.'&r='.$initialRut.'</div>';
                echo '<div class="alert alert-info mt-3" role="alert">Sinctonizar para link de pago en cotización: <a disabled="true"><strong>Pronto</strong></a></div>';
              } else if ($deltaDias>5) {
                echo '<div class="alert alert-danger mt-3" role="alert">Advertencia: Esta cotización ya venció. </div>';
              } else if ($deltaDias <5) {
                echo '<div class="alert alert-success mt-3" role="alert">Advertencia: Esta cotización aun está vigente. </div>';
                echo '<div class="alert alert-primary mt-3" role="alert">Link de Cliente: <a href="http://192.168.1.105/accesoClientes/checkIn/verCotizacion.php?qn='.$initialQuote.'&r='.$initialRut.'" target="_blank">192.168.1.105/accesoClientes/checkIn/verCotizacion.php?qn='.$initialQuote.'&r='.$initialRut.'</a></div>';
                echo '<div class="alert alert-info mt-3" role="alert">Sinctonizar para link de pago en cotización: <a disabled="true"><strong>Pronto</strong></a></div>';
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
                    <small class="float-right"><strong>Fecha de Emisión: </strong><?php echo $fechaEmision->format('d/m/Y'); ?></small>
                  </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  Cliente:
                  <address>
                    <strong><?php echo $encabezado['RSocial']; ?></strong> - Cód. Cliente: <strong><?php echo $rutCliente; ?></strong><br>
                    <?php echo $encabezado['direccion']; ?><br>
                    Cod.Ciudad: <?php echo $encabezado['comuna']; ?><br>
                    Teléfono: <?php echo $encabezado['fono']; ?><br>
                    E-Mail: <?php $encabezado['email']; ?>
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
                      <th class="text-center">#</th>
                      <th class="text-center">Cód</th>
                      <th>Detalle/Descripción</th>
                      <th class="text-center">Cant</th>
                      <th class="text-center">UM</th>
                      <th class="text-center">Unit Bruto</th>
                      <th class="text-center">Dcto</th>
                      <th class="text-center">Valor Dcto.</th>
                      <th class="text-center">Total</th>
                      <th class="text-center">Stock</th>
                    </tr>
                    </thead>
                    <tbody>
                <?php
                  $fila = 1;
                  $checkDetalle = $con->prepare($tsql,[
                    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
                  ]);
                  $checkDetalle->execute();
                  while ($row = $checkDetalle->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                      <td class="text-center"><?php echo $fila; ?></td>
                      <td class="text-center"><?php echo $row['SKU']; ?></td>
                      <td><?php echo $row['Descripcion']; ?></td>
                      <td class="text-center"><?php echo '$ '.number_format($row['Cantidad'],'2',',','.'); ?></td>
                      <td class="text-center"><?php echo $row['UM']; ?></td>
                      <td class="text-center"><?php echo '$ '.number_format($row['UnitBruto'],0,',','.'); ?></td>
                      <td class="text-center"><?php echo '$ '.number_format($row['porcDesc'],2,',','.'); ?> % </td>
                      <td class="text-center"><?php echo '$ '.$row['NetoDesc']; ?></td>
                      <td class="text-center"><?php echo number_format($row['BrutoSKU'],0,',','.'); ?></td>
                      <td class="text-center">
                        <?php if ($row['STOCKACTUAL']===0) { ?>
                          <span class="right badge badge-danger">Sin stock</span>
                        <?php } else {
                            echo $row['STOCKACTUAL'];
                          }
                        ?>
                      </td>
                    </tr>
                <?php
                  $fila++; }
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
                        <td><?php echo '$ '.number_format(round($encabezado['NetoTotal'],0,PHP_ROUND_HALF_UP),0,',','.'); ?></td>
                      </tr>
                      <tr>
                        <th>I.V.A.</th>
                        <td><?php echo '$ '.number_format(round($encabezado['IvaTotal'],0,PHP_ROUND_HALF_UP),0,',','.'); ?></td>
                      </tr>
                      <tr>
                        <th>TOTAL</th>
                        <td><?php echo '$ '.number_format(round($encabezado['BrutoTotal'],0,PHP_ROUND_HALF_UP),0,',','.'); ?></td>
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
                  <?php
                    if ($deltaDias<=5) {
                  ?>
                  <button disabled="true" type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                    <i class="fas fa-envelope"></i> Enviar cotización a cliente (pronto)
                  </button>
                  <?php
                    }
                    sqlsrv_close($conn);
                  ?>
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
  <!-- /.content-wrapper -->
  <footer class="main-footer no-print">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
</body>
</html>
