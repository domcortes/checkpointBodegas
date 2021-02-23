<?php
  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    unset($_SESSION['entrada']);
    require_once("../../php/clases/Conexion.php");
    require_once("../../php/clases/crud.php");
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
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../../plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">BÚSQUEDA DE COTIZACIONES VIGENTES</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <form action="../../php/clases/procesos/searchQuote.php" method="POST">
          <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Por favor ingrese un número de cotizacion válido</h3>
            <div class="card-tools">
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Número de cotización</label>
                  <input type="text" name="numeroCotizacion" id="numeroCotizacion" class="form-control" placeholder="Ingrese el codigo unico de cotización" required>
                </div>
                <!-- /.form-group -->
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Rut sin digito verificador</label>
                  <input type="number" name="rut" id="rut" class="form-control" placeholder="Ingrese el codigo unico de cotización" required>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <input class="btn btn-success" type="submit" name="" value="Buscar cotización">
          </div>
        </div>
        </form>
        <!-- /.card -->
          </div>
          <!-- /.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../../dist/js/demo.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="../../plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="../../plugins/raphael/raphael.min.js"></script>
<script src="../../plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="../../plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>

<!-- PAGE SCRIPTS -->
<script src="dist/js/pages/dashboard2.js"></script>
<script>
  function pendingDocs(){
     document.checkPendingDocs.submit()
  }
</script>
</body>
</html>

