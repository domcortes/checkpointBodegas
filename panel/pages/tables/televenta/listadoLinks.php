<?php
  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    unset($_SESSION['entrada']);
    require_once("../../../php/clases/Conexion.php");
    require_once("../../../php/clases/crud.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Intranet Chelech</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
            <h1>Listado de links</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            </ol>
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
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Fecha creación</th>
                    <th>Vale transitorio</th>
                    <th class="text-center">Tipo Documento</th>
                    <th>Nro. Documento</th>
                    <th>Monto</th>
                    <th class="text-center">Acciones</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                      $obj = new metodos();
                      $sql = "SELECT * from url";
                      $links = $obj->mostrarDatos($sql);
                      foreach ($links as $url) {
                    ?>
                  <tr>
                    <form method="post" action="/panel/php/clases/procesos/actualizarLink.php">
                      <td class="text-center"><?php echo $url['fechaCreacion']; ?></td>
                      <td id="vatra" name="vatra"><?php echo $url['valeTransitorio'] ?></td>
                      <input type="hidden" name="idurl" id="idurl"value="<?php echo base64_encode(base64_encode(base64_encode($url['idUrl']))); ?>">
                      <td>
                        <?php if ($url['tipoDocumento']==='not'): ?>
                          <select class="form-control" required name="tido" id="tido">
                            <option <?php if($url['tipoDocumento']==='not'){ echo 'selected="true"';}?> value="not">Seleccione una opción</option>
                            <option <?php if($url['tipoDocumento']==='FCV'){ echo 'selected="true"';}?> value="FCV" >Factura</option>
                            <option <?php if($url['tipoDocumento']==='BLV'){ echo 'selected="true"';}?> value="BLV">Boleta</option>
                            <option <?php if($url['tipoDocumento']==='NCE'){ echo 'selected="true"';}?> value="NCE">Nota de crédito</option>
                          </select>
                        <?php endif ?>

                        <?php
                          if ($url['tipoDocumento']!='not') {
                            if ($url['tipoDocumento']=='SCO') {
                              echo '<p class="text-center">Sin concretar</p>';
                            } else {
                              echo '<p class="text-center">'.$url['tipoDocumento'].'</p>';
                            }
                          }
                        ?>
                      </td>
                      <td>
                        <?php
                          if($url['boleta']!="0"){
                        ?>
                          <p class="text-center"><?php echo $url['boleta'];?></p>
                        <?php } else { ?>
                          <input class="form-control" type="number" name="nudo" id="nudo" value="<?php $url['boleta'];?>">
                        <?php } ?>
                      </td>
                      <td class="text-center"><?php echo '$ '.number_format($url['monto'],0,",","."); ?></td>
                      <td class="align-item-center">
                        <?php if($url['boleta']==="0" || $url['tipoDocumento']=='SCO'){ ?>
                          <div class="btn-group btn-group-lg btn-block" role="group" aria-label="">
                            <input type="submit" name="ingrearDocumento" value="Ingresar" class="btn btn-success">
                          </div>
		                    <?php } else {
                          echo '<p class="text-center">No hay acciones disponibles</p>'; }?>
                      </td>
                    </form>
                  </tr>
                <?php }  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Fecha creación</th>
                    <th>Vale transitorio</th>
                    <th class="text-center">Tipo Documento</th>
                    <th>Nro. Documento</th>
                    <th>Monto</th>
                    <th class="text-center">Acciones</th>
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
<!-- DataTables -->
<script src="../../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- AdminLTE App -->
<script src="../../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../../dist/js/demo.js"></script>
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
