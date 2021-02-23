<?php

  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    $rolUsuario = $_SESSION['nivelAcceso'];
    if ($rolUsuario==='administrador') {
      ob_start();
      $initial = $_GET['i'];
      $rutCliente = base64_decode($initial);
      $idUsuario = $_SESSION['idUsuario'];
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
            <h1>CONSULTA DE DOCUMENTOS PENDIENTES</h1>
          </div>
          <div class="col-sm-6">
            <!--<a  class="btn btn-info" href="/reporteDocumentos.php?i=<?php echo $initial; ?>">Exportar Cartola</a>-->
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Documentos pendientes cliente <strong><?php echo $rutCliente; ?></strong></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th scope="col">TIPO DOC</th>
                      <th scope="col"># DOC</th>
                      <th scope="col" class="text-center">FECHA DOC</th>
                      <th scope="col" class="text-center">VALOR DOC</th>
                      <th scope="col" class="text-center">ABONO DOC</th>
                      <th scope="col" class="text-center">SALDO</th>
                      <th scope="col" class="text-center">SALDO CAPITAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $tsql= "SELECT  TIDO,
                                  NUDO,
                                  ENDO,
                                  FEEMDO,
                                  FE01VEDO,
                                  ESPGDO,
                                  VABRDO,
                                  VAABDO,
                                  VABRDO-VAABDO AS SALDO
                          FROM MAEEDO
                          WHERE ESPGDO='P'
                          AND ENDO = '$rutCliente'
                          ORDER BY FEEMDO ASC;";
                    $sentencia = $con->prepare($tsql,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
                    $sentencia->execute();
                    $saldoAcumulado=0;
                    while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                      if ($row['TIDO']==='NCV') {
                        $saldoAcumulado = $saldoAcumulado - $row['SALDO'];
                      } else {
                        $saldoAcumulado = $saldoAcumulado + $row['SALDO'];
                      }
                      $fecha = new DateTime($row['FEEMDO']);
                    ?>
                      <tr>

                        <td><?php echo ($row['TIDO'] . PHP_EOL); ?></td>
                        <td><?php echo ($row['NUDO'] . PHP_EOL); ?></td>
                        <td class="text-center"><?php echo $fecha->format('d/m/Y'); ?></td>
                        <td class="text-center"><?php echo number_format($row['VABRDO'],0,",","."); ?></td>
                        <td class="text-center"><?php echo number_format($row['VAABDO'],0,",","."); ?></td>
                        <td class="text-center"><?php if($row['TIDO']==='NCV'){echo '-'.number_format($row['SALDO'],0,",",".");}else {echo number_format($row['SALDO'],0,",",".");} ?></td>
                        <td class="text-center"><?php echo number_format($saldoAcumulado,0,",","."); ?></td>
                      </tr>
                    <?php } $sentencia=null; $con = null; ?>
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
