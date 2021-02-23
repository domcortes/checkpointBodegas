<?php

  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    unset($_SESSION['entrada']);
    require_once("php/clases/Conexion.php");
    require_once("php/clases/crud.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Checkpoint Chelech</title>
  <style type="text/css">
    .main{
      border: 1px;
      display: inline-block;
      width: auto;
      margin: auto;
      padding: 20px, 20px;
      text-align: justify;
    }
  </style>
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
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

  <?php include "aside.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bienvenido <?php $obj = new metodos();
            $sql = "select nombreUsuario from usuarios where idusuario=$idUsuario";
            $resultName = $obj->mostrarDatos($sql);
            foreach($resultName as $name){
              echo ucwords($name['nombreUsuario']);
            }
          ?></h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ingresos de trabajadores</span>
                <span class="info-box-number">
                  <?php $objCant = new metodos(); $queryCantComprador= "SELECT * FROM ingreso where tipoIngreso='trabajador'"; $conteoCompradores = $objCant->mostrarDatos($queryCantComprador); echo sizeof($conteoCompradores);?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ingreso de abastecimiento</span>
                <span class="info-box-number"><?php $objCant = new metodos(); $queryCantComprador= "SELECT * FROM ingreso where tipoIngreso='abastecimiento'"; $conteoCompradores = $objCant->mostrarDatos($queryCantComprador); echo sizeof($conteoCompradores);?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ingresos de compradores</span>
                <span class="info-box-number"><?php $objCant = new metodos(); $queryCantComprador= "SELECT * FROM ingreso where tipoIngreso='comprador'"; $conteoCompradores = $objCant->mostrarDatos($queryCantComprador); echo sizeof($conteoCompradores);?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Usuarios registrados</span>
                <span class="info-box-number">
                  <?php
                    $obj = new metodos();
                    $sql = "select * from usuarios";
                    $cantUser = $obj->mostrarDatos($sql);
                    echo sizeof($cantUser);
                  ?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <div class="col-md-8">
            <!-- MAP & BOX PANE -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">Ultimos ingresos</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>Tipo</th>
                      <th>Nombre</th>
                      <th>Hora Entrada</th>
                      <th>Hora Salida</th>
                      <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                      <?php
                        $i=0;
                        $obj = new metodos();
                        $sql = "SELECT * from ingreso order by horaIngreso desc";
                        $listaEntradas = $obj->mostrarDatos($sql);
                        $showEntradas = array_slice($listaEntradas,0,7);
                        $cantEntradas = sizeof($listaEntradas);
                        if($i<=7){
                          if($cantEntradas===0){
                      ?>
                            <tr>
                              <td><a href="">No hay registros</a></td>
                            </tr>
                      <?php
                          $i++;
                        } else {
                          foreach($showEntradas as $entrada){
                      ?>
                            <tr>
                              <td><?php echo ucwords($entrada['tipoIngreso']) ?></td>
                              <td><?php
                              $idEntrada = $entrada['idIngreso'];
                              $qwerty = new metodos();
                              $queryTitular = "SELECT * FROM personas where id_Ingreso=$idEntrada";
                              $titulares = $qwerty->mostrarDatos($queryTitular);
                              echo ucwords($titulares[0]['nombrePersona']);
                              ?></td>
                              <td><?php echo $entrada['horaIngreso'] ?></td>
                              <td><?php echo $entrada['horaSalida'] ?></td>
                              <!--definir variables para status-->
                              <td><span class="badge badge-<?php
                                                              if($entrada['statusIngreso']==='Pendiente'){
                                                                echo "danger";
                                                              } else if ($entrada['statusIngreso']==='Entregado'){
                                                                echo "success";
                                                              } else if ($entrada['statusIngreso']==='Procesando'){
                                                                echo "info";
                                                              }?>"><?php echo ucwords($entrada['statusIngreso']) ?></span></td>
                            </tr>
                    <?php $i++;} } }?>
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <a href="/panel/pages/tables/ingresos.php" class="btn btn-sm btn-secondary float-right">Ver todos los ingresos</a>
              </div>
              <!-- /.card-footer -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->

          <div class="col-md-4">
            <!-- Info Boxes Style 2 -->
            <div class="info-box mb-3 bg-warning">
              <span class="info-box-icon"><i class="fas fa-tag"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ingreso comprador</span>
                <a href="pages/forms/addCustomer.php" class="info-box-number">INGRESAR</a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-success">
              <span class="info-box-icon"><i class="far fa-heart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ingreso trabajador</span>
                <a href="pages/forms/addSeller.php" style="color: white; font-weight: bold;">INGRESAR</a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-danger">
              <span class="info-box-icon"><i class="fas fa-cloud-download-alt"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Ingreso para abastecimientos</span>
                <a href="" style="color: white; font-weight: bold;">INGRESAR</a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
            <div class="info-box mb-3 bg-info">
              <span class="info-box-icon"><i class="fas fa-cash-register"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Consulta Financiera</span>
                <a href="/panel/pages/forms/checkPendingDocs.php" style="color: white; font-weight: bold;">REVISAR</a>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020 <a href="http://www.chelech.cl">Empresas Chelech</a>.</strong>
    Derechos reservados
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> beta 1.0.1
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="dist/js/pages/dashboard2.js"></script>
<script>
  function pendingDocs(){
     document.checkPendingDocs.submit()
  }
</script>
</body>
</html>
