<?php
	session_start();
	if (!$_SESSION['verificar']) {
		header('');
	} else {
    if(isset($_POST['bosel'])){
      $bodega = $_POST['bosel'];
    } else if (isset($_GET['boselget'])){
      $bodega = $_GET['boselget'];
    } else {
      echo '<script>
        alert("No has seleccionado bodega, por favor selecciona una");

      </script>';
    }
    echo $bodega;
    ob_start();
      require_once("../../php/clases/Conexion.php");
      require_once("../../php/clases/cc2.php");
      require_once("../../php/clases/crud.php");
      ob_start();
      $idUsuario = $_SESSION['idUsuario'];
      $rolUsuario = $_SESSION['nivelAcceso'];
      $tsql = "SELECT
                dbo.MAEST.KOBO AS Bodega,
                dbo.MAEST.KOPR AS SKU,
                dbo.MAEPR.NOKOPR AS DESCRIPCION,
                dbo.MAEST.STFI1 AS Stock,
                dbo.TABBOPR.STMIPR AS STMinimo,
                dbo.TABBOPR.STMAPR AS STMax,
                dbo.TABPRE.PP01UD AS preUd
              FROM
                dbo.MAEST
              INNER JOIN
                dbo.MAEPR ON dbo.MAEST.KOPR = dbo.MAEPR.KOPR
              INNER JOIN
                dbo.TABBOPR ON dbo.MAEST.KOPR = dbo.TABBOPR.KOPR
              AND dbo.MAEST.KOBO = dbo.TABBOPR.KOBO
              INNER JOIN
                dbo.TABPRE ON dbo.MAEST.KOPR = dbo.TABPRE.KOPR
              WHERE (dbo.MAEST.KOBO = '$bodega')
              AND
                (dbo.MAEST.STFI1 <> 0)";
      $sentencia2 = $con->prepare($tsql,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
      $sentencia2->execute();
      $dataClient = $sentencia2->fetch(PDO::FETCH_ASSOC);

  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LISTA DE PRODUCTOS DE BODEGA <?php echo $bodega;?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
    <!-- DataTables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="../../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="../../plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="../../plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item">
      	<a href="panel/pages/forms/selectorBodega.php" class="btn btn-primary">CAMBIO DE BODEGA</a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

<?php include "../../aside.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- /.card -->
        <div class="card card-success">
          <div class="card-header">
            <h3 class="card-title">LISTADO DE PRODUCTOS DE BODEGA <?php echo $bodega;?> (SOLO PRODUCTOS CON STOCK) </h3>
            <span id="resultado"></span>
          </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th># SATO</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Foto</th>
                    <th>Precio Actual</th>
                    <th>Stock</th>
                    <th>Stock Critico</th>
                    <th>Stock Maximo</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                	<?php
                		while ($row = $sentencia2->fetch(PDO::FETCH_ASSOC)) {
                	?>
		                <tr>
		                  <form action="">
                        <td><p class="text-center"><?php echo $row['SKU'];?></p></td>
                        <td><?php echo $row['DESCRIPCION']?></td>
                        <td>
                          <textarea style="font-size: 12px;" class="form-control" name="descripcionProducto" id="descripcionProducto" cols="35" rows="3" placeholder="sin descripcion... x ahora... 😀" onchange="duplicarDescripcion(this.value)"></textarea>
                        </td>
                        <td><input type="text" class="form-control" id="imagen" name="imagen" placeholder="URL de la foto"></td>
                        <td><?php echo "$ ".number_format($row['preUd'],0,',','.');?></td>
                        <td><?php echo $row['Stock']?></td>
                        <td><?php echo $row['STMinimo']?></td>
                        <td><?php echo $row['STMax']?></td>
                        <td>
                          <select name="catalogo" id="catalogo" class="form-control">
                            <option value="">Seleccione un catalogo</option>
                            <?php
                                $sql = "SELECT idCatalogo, nombreCatalogo FROM catalogo WHERE vigente='si'";
                                $catalogos = $obj->mostrarDatos($sql);
                                foreach($catalogos as $catalogo){
                            ?>
                            <option value="<?php echo $catalogo['idCatalogo']?>"><?php echo $catalogo['nombreCatalogo']?></option>
                            <?php } ?>
                          </select>
                          <input type="hidden" value="<?php echo $row['Bodega'] ?>" id="bodega" name="bodega">
                          <input type="hidden" value="<?php echo $row['SKU'];?>" id="sato" name="sato">
                          <input type="hidden" value="<?php echo $row['DESCRIPCION'];?>" id="nombre" name="nombre">
                          <input type="hidden" value="<?php echo $row['preUd'];?>" id="precioVenta" name="precioVenta">
                          <input type="button" href="javascript:;" onclick="realizaProceso($('#bodega').val(), $('#catalogo').val(), $('#imagen').val(), $('#sato').val(), $('#nombre').val(), $('#descripcionProducto').val(), $('#precioVenta').val(), $('#idUsuario').val());return false;" value="Sumar a catalogo" class="btn btn-success btn-block">
                        </td>
                      </form>
		                </tr>
	            	<?php
	            		}
						$sentencia2 = null;
						$con = null;
	            	?>
                </tbody>
                <tfoot>
                  <tr>
                    <th># SATO</th>
                    <th>Nombre</th>
                    <th>Descripcion</th>
                    <th>Foto</th>
                    <th>Precio Actual</th>
                    <th>Stock</th>
                    <th>Stock Critico</th>
                    <th>Stock Maximo</th>
                    <th>Acciones</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>

        <!--<div id="tablaDeudores"></div>-->

      </div><!-- /.container-fluid -->
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
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- DataTables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- date-range-picker -->
<script src="../../plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="../../plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="../../plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
</script>
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
      "paging": true,
      "searching": true,
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

<script>
  function realizaProceso(bodega, catalogo, imagen, sato, nombre, descripcionProducto, precioVenta, idUsuario){
    var parametros = {
      "bodega" : bodega,
      "catalogo" : catalogo,
      "imagen":imagen,
      "sato":sato,
      "nombre":nombre,
      "descripcionProducto":descripcionProducto,
      "precioVenta":precioVenta,
      "idUsuario":idUsuario,
    };
    $.ajax({
      data:  parametros, //datos que se envian a traves de ajax
      url:   '../../php/goes/agregarCatalogo.php', //archivo que recibe la peticion
      type:  'post', //método de envio
      success:  function (response) {
        $("#resultado").html(response);
      }
    });
  }
</script>
</body>
</html>
