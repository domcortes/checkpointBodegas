<?php

  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    require_once("../../php/clases/Conexion.php");
    require_once("../../php/clases/crud.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Checkpoint Chelech - Agregar comprador</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../plugins/daterangepicker/daterangepicker.css">
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

<?php include "../../aside.php"; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>INGRESO DE COMPRADORES A BODEGA</h1>
          </div>
          <div class="col-sm-6">
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">En esta sección usted ingresa a las personas que han comprado mercadería y necesitan retirarlas en bodega</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form method="post" action="../../php/clases/procesos/firstStepCustomer.php" onsubmit="return enviar();">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Tipo de Ingreso</label>
                    <select class="form-control select2" style="width: 100%;" id="tipoIngreso" name="tipoIngreso" required>
                      <option selected="selected" value="comprador">Comprador</option>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Tipo de documento</label>
                    <select class="form-control select2" style="width: 100%;" name="documentType" id="documentType" required>
                      <option value="0" selected="selected">Seleccione una opción</option>
                      <option value="factura">Factura</option>
                      <option value="boleta">Boleta</option>
                      <option value="guiaDespacho">Guía de despacho</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Nombre comprador titular</label>
                    <input type="text" name="customer" id="customer" placeholder="Nombre completo" class="form-control" required>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Acompañantes</label>
                    <input id="acompanantes" name="acompanantes" type="checkbox" checked data-bootstrap-switch>
                  </div>
                  <div class="form-group">
                    <label>Entrega de EPP</label>
                    <input id="epp" name="epp" type="checkbox" checked data-bootstrap-switch>
                  </div>
                </div>
                <!-- /.col -->
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Origen</label>
                    <select class="form-control select2" style="width: 100%;" name="customerOrigin" id="customerOrigin" required>
                      <option value="0" selected="selected">seleccione una opción</option>
                      <?php
                        $obj= new metodos();
                        $sql = "SELECT idOrigen, nombreOrigen, valorOrigen from origen";
                        $origenes = $obj->mostrarDatos($sql);
                        foreach($origenes as $origen){
                      ?>
                      <option value="<?php echo $origen['valorOrigen'] ?>"><?php echo $origen['nombreOrigen'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Número de documento</label>
                    <input type="number" class="form-control" placeholder="Ingrese el numero de doc." min="1" name="docNumber" id="docNumber" required>
                  </div>
                  <div class="form-group">
                    <label>Rut Titular</label>
                    <input class="form-control" id="rutTitular" name="rutTitular" type="text" required>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
              <button class="btn btn-success" name="ingresoComprador" id="ingresoComprador">Ingresar comprador</button>
            </form>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
          <div class="card-footer">

          </div>
        </div>
        <!-- /.card -->
      </div><!-- /.container-fluid -->
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
<!-- Select2 -->
<script src="../../plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="../../plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/moment/moment.min.js"></script>
<script src="../../plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
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
<script type="text/javascript">
  function enviar(){
    var origenComprador = document.getElementById("customerOrigin").value;
    var documento = document.getElementById("documentType").value;
    var nombreComprador=document.getElementById("customer").value;
    var rutComprador=document.getElementById("rutTitular").value;
    if(origenComprador==="0"){
      alert("Debe seleccionar un lugar de origen de la compra");
      document.getElementById("customerOrigin").focus();
      return false;
    }

    if(documento==="0"){
      alert("Debe seleccionar un tipo de documento");
      document.getElementById("documentType").focus();
      return false;
    }

    if(nombreComprador===null || rutComprador===null){
      alert("Debes ingresar un nombre y rut para poder continuar");
      return false;
    }
  }
</script>
</body>
</html>
