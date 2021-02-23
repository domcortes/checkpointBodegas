<?php

session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    $rolUsuario = $_SESSION['nivelAcceso'];
    if ($rolUsuario==='administrador') {
      ob_start();
      $initial = $_POST['idCliente'];
      $monthSelected = (int)$_POST['month'];
          $year=(int)$_POST['year'];
      $proxVencimiento = $monthSelected;

      if ($monthSelected<10) {
        $month = '0'.$monthSelected;
      } else {
        $month = $monthSelected;
      }

      $lastDay = cal_days_in_month(CAL_GREGORIAN, $monthSelected, $year);
      $dateStart = '01-'.$month.'-'.$year;
      $dateEnd = $lastDay.'-'.$month.'-'.$year;
      $startDateSQL = $year.$month.'01';
      $endDateSQL = $year.$month.$lastDay;

      $rutCliente = base64_decode($initial);
      $idUsuario = $_SESSION['idUsuario'];
      $rolUsuario = $_SESSION['nivelAcceso'];
      require_once("../../php/clases/Conexion.php");
      require_once("../../php/clases/cc2.php");
      require_once("../../php/clases/crud.php");
    } else {
      echo '<script>alert("No tienes acceso a esta ventana, seras redirigido al home"); window.location="/panel/home.php";</script>';
    }
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Checkpoint Chelech - Listado de documentos pendientes</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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

<?php include "../../aside.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
 <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <?php
              $saldoAcumulado = 0;
              $tsql2 = "SELECT * FROM MAEEN WHERE KOEN = '$rutCliente';";
              $sentencia2 = $con->prepare($tsql2,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
              $sentencia2->execute();
              $dataClient = $sentencia2->fetch(PDO::FETCH_ASSOC);
            ?>
            <h1>CONSULTA DE CUOTA CLIENTE <?php echo $rutCliente; ?></h1>
          </div>
          <div class="col-sm-6">

          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
                    <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Consulta otros periodos</h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form id="formReport" name="formReport" method="POST">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $initial;?>">
                    <label>Mes</label>
                    <select id="month" name="month" class="form-control select2" style="width: 100%;">
                      <option <?php if ($monthSelected===1) {echo "selected";} ?> value="01">Enero</option>
                      <option <?php if ($monthSelected===2) {echo "selected";} ?> value="02">Febrero</option>
                      <option <?php if ($monthSelected===3) {echo "selected";} ?> value="03">Marzo</option>
                      <option <?php if ($monthSelected===4) {echo "selected";} ?> value="04">Abril</option>
                      <option <?php if ($monthSelected===5) {echo "selected";} ?> value="05">Mayo</option>
                      <option <?php if ($monthSelected===6) {echo "selected";} ?> value="06">Junio</option>
                      <option <?php if ($monthSelected===7) {echo "selected";} ?> value="07">Julio</option>
                      <option <?php if ($monthSelected===8) {echo "selected";} ?> value="08">Agosto</option>
                      <option <?php if ($monthSelected===9) {echo "selected";} ?> value="09">Septiembre</option>
                      <option <?php if ($monthSelected===10) {echo "selected";} ?> value="10">Octubre</option>
                      <option <?php if ($monthSelected===11) {echo "selected";} ?> value="11">Noviembre</option>
                      <option <?php if ($monthSelected===12) {echo "selected";} ?> value="12">Diciembre</option>
                    </select>
                  </div>
                  <strong>Consulta actual:</strong> Periodo <?php echo $startDateSQL." > ".$endDateSQL; ?>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Año</label>
                     <select id="year" name="year" class="form-control select2" style="width: 100%;">
                      <?php
                      $anio = 2000;
                      while($anio<=2030){
                      ?>
                      <option <?php if ($year===$anio) {echo "selected";} ?> value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                      <?php
                          $anio++;
                        }
                      ?>
                    </select>
                  </div>
                  <input type="button" class="btn btn-secondary btn-sm" name="seeScreen" id="seeScreen" value="VER" onclick="document.formReport.action = '/panel/pages/tables/consultaCuotaPeriodo.php'; document.formReport.submit()"/>
                  <input type="button" class="btn btn-primary btn-sm" name="seePDF" id="seePDF" value="PDF" onclick="document.formReport.action = '/reporteDocumentos.php'; document.formReport.submit()"/>
                  <a href="/panel/pages/forms/checkPendingDocs.php" class="btn btn-warning btn-sm">BUSCAR OTRO RUT</a>
                  <?php
                    if(isset($_POST['pdf'])){
                      header('Location: /reporteDocumentos.php');
                      ob_end_flush();
                      exit;
                  } else if (isset($_POST['see'])){
                      header('Location:/panel/pages/tables/consultaCuotaPeriodo.php');
                      ob_end_flush();
                      exit;
                  }
                  ?>
                </div>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th scope="col">TIPO DOC</th>
                      <th scope="col"># DOC</th>
                      <th scope="col" class="text-center">FECHA DOC</th>
                      <th scope="col" class="text-center">ESTADO DOC</th>
                      <th scope="col" class="text-center">VENCIMIENTO CUOTA</th>
                      <th scope="col" class="text-center">ESTADO CUOTA</th>
                      <th scope="col" class="text-center">MONTO COMPRA</th>
                      <th scope="col" class="text-center">VALOR CUOTA</th>
                      <th scope="col" class="text-center">ABONO</th>
                      <th scope="col" class="text-center">SALDO CUOTA</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $tsql= "SELECT DISTINCT
                        dbo.MAEEDO.TIDO AS Tipo,
                        dbo.MAEEDO.NUDO AS Numero,
                        -- dbo.MAEEDO.ENDO AS Rut
                        dbo.MAEEDO.FEEMDO AS Fecha,
                        dbo.MAEEDO.ESPGDO AS Estado,
                        dbo.MAEVEN.FEVE AS FVencimiento,
                        dbo.MAEVEN.ESPGVE,
                        dbo.MAEEDO.VABRDO AS Bruto,
                        dbo.MAEVEN.VAABVE AS Abono,
                        dbo.MAEVEN.VAVE AS VCuota,
                        dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS SALDO
                      FROM dbo.MAEEDO
                        INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
                        RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
                      WHERE
                        (dbo.MAEEDO.TIDO IN ('FCV', 'BLV','RIN'))
                        -- AND (dbo.MAEEDO.ESPGDO = 'P')
                        -- AND (dbo.MAEVEN.ESPGVE <> 'C')
                        AND (dbo.MAEVEN.FEVE BETWEEN '$startDateSQL' AND '$endDateSQL')
                        AND (dbo.MAEEDO.ENDO = '$rutCliente')
                      ORDER BY dbo.MAEVEN.FEVE ASC";

                      $sentencia = $con->prepare($tsql,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
                      $sentencia->execute();
                      $dataClient = $sentencia->fetch(PDO::FETCH_ASSOC);

                    while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                      $fecha = new DateTime($row['Fecha']);
                      $vencimiento = new DateTime($row['FVencimiento']);
                    ?>
                      <tr>
                        <td><?php echo ($row['Tipo'] . PHP_EOL); ?></td>
                        <td><?php echo ($row['Numero'] . PHP_EOL); ?></td>
                        <td class="text-center"><?php echo $fecha->format('d/m/Y'); ?></td>
                        <td class="text-center"><?php echo ($row['Estado'] . PHP_EOL); ?></td>
                        <td class="text-center"><?php echo $vencimiento->format('d/m/Y'); ?></td>
                        <td class="text-center"><?php echo ($row['ESPGVE'] . PHP_EOL); ?></td>
                        <td class="text-center"><?php echo ($row['Bruto'] . PHP_EOL); ?></td>
                        <td class="text-center"><?php echo ($row['VCuota'] . PHP_EOL); ?></td>
                        <td class="text-center"><?php echo ($row['Abono'] . PHP_EOL); ?></td>
                        <td class="text-center"><?php echo ($row['SALDO'] . PHP_EOL); ?></td>
                      </tr>
                    <?php  }
                      $sentencia = null;
                      $sentencia2 = null;
                      $con = null;
                    ?>
                  </tbody>
                  <tfoot>
                  <tr>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="http://www.chelech.cl">Empresas Chelech</a>.</strong>
      Derechos reservados
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> beta 1.0.1
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
