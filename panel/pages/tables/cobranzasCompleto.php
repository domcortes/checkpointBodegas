<?php

  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  } else {
    $rolUsuario = $_SESSION['nivelAcceso'];
    if ($rolUsuario==='administrador') {
      ob_start();
      $idUsuario = $_SESSION['idUsuario'];
      require_once("../../php/clases/Conexion.php");
      require_once("../../php/clases/cc2.php");
      require_once("../../php/clases/crud.php");
      if ($_POST) {
        $ddStart = substr($_POST['from_date'], 0, 2);
        $mmStart = substr($_POST['from_date'], 3, 2);
        $aaaaStart = substr($_POST['from_date'], 6, 4);

        $ddEnd = substr($_POST['to_date'], 0, 2);
        $mmEnd = substr($_POST['to_date'], 3, 2);
        $aaaaEnd = substr($_POST['to_date'], 6, 4);

        $salidafechaIn = $aaaaStart.$mmStart.$ddStart;
        $salidafechaOut = $aaaaEnd.$mmEnd.$ddEnd;
      } else {
        $fecha = new DateTime();
        $fecha->modify('first day of this month');
        $fecha2 = new DateTime();
        $fecha2->modify('last day of this month');
        $salidafechaIn = str_replace('-', '', $fecha->format('Y-m-d'));
        $salidafechaOut = str_replace('-', '', $fecha2->format('Y-m-d'));
      }

              echo $salidafechaIn;
        echo $salidafechaOut;
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
  <title>Listado de cobranzas</title>
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
            <h1>Consulta masiva de deudores</h1>
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
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Criterios de búsqueda</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <form action="cobranzasCompleto.php" method="post">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Fecha Inicio</label>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="from_date" id="from_date">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form-group -->
<!--                   <div class="form-group">
                    <label>switch por si acaso </label>
                    <div class="input-group">
                      <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success">
                    </div>
                  </div> -->
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
                <div class="col-md-6">
<!--                   <div class="form-group">
                    <label>Minimal</label>
                    <select class="form-control select2" style="width: 100%;" name="tipoFiltro" id="tipoFiltro">
                      <option selected="selected">Alabama</option>
                      <option>Alaska</option>
                      <option>California</option>
                      <option>Delaware</option>
                      <option>Tennessee</option>
                      <option>Texas</option>
                      <option>Washington</option>
                    </select>
                  </div> -->
                  <!-- /.form-group -->
                  <div class="form-group">
                    <label>Fecha término:</label>

                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                      </div>
                      <input type="text" class="form-control" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask name="to_date" id="to_date">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.col -->
              </div>
            <!-- /.row -->
            <div class="card-footer">
              <div class="btn-group" role="group" aria-label="Basic example">
                <button type="submit" class="btn btn-primary">Buscar</button>
                <a href="excelCuotasClientes.php?in=<?php echo $salidafechaIn.'&out='.$salidafechaOut; ?>" type="submit" class="btn btn-warning">Exportar</a>
                <a href="cobranzasCompleto.php" class="btn btn-info">Mostrar todo</a>
              </div>
            </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
        <div class="card">
          <div class="card-header">
              <?php if ($_POST): ?>
                <h3 class="card-title">Resultados de búsqueda desde <strong><?php echo $ddStart.'/'.$mmStart.'/'.$aaaaStart.'</strong> al <strong>'.$ddEnd.'/'.$mmEnd.'/'.$aaaaEnd?></strong></h3>
              <?php endif ?>
              <?php if (!$_POST): ?>
                <h3 class="card-title">Resultados de búsqueda standard</h3>
              <?php endif ?>
          </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th># DOC</th>
                    <th>Rut</th>
                    <th>Titular</th>
                    <th>Dirección</th>
                    <th class="text-center">DATO COMPRA</th>
                    <th class="text-center">VENCIMIENTO CUOTA</th>
                    <th class="text-center">ABONO</th>
                    <th class="text-center">SALDO CUOTA</th>
                    <th>Contacto</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $nsql= "SELECT DISTINCT
                              TOP (100) PERCENT
                                dbo.MAEEN.NOKOEN AS RSocial,
                                dbo.MAEEN.DIEN AS Direccion,
                                dbo.MAEEN.FOEN AS Telefono,
                                dbo.MAEEN.KOEN AS Rut,
                                dbo.MAEEN.EMAIL AS Email,
                                dbo.MAEEDO.TIDO AS Tipo,
                                dbo.MAEEDO.NUDO AS Numero,
                                dbo.MAEEDO.FEEMDO AS Fecha,
                                dbo.MAEVEN.FEVE AS FVencimiento,
                                dbo.MAEEDO.ESPGDO AS Estado,
                                datediff(day,dbo.MAEEDO.FEEMDO,dbo.MAEVEN.FEVE) AS DIAS,
                                dbo.MAEVEN.ESPGVE, dbo.MAEEDO.VABRDO AS valorCompra,
                                dbo.MAEVEN.VAVE AS VCuota,
                                dbo.MAEVEN.VAABVE AS Abono,
                                dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS PorPagar
                            FROM dbo.MAEEDO
                            INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN AND dbo.MAEEDO.SUENDO = dbo.MAEEN.SUEN
                            RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
                            WHERE (dbo.MAEEDO.TIDO IN ('FCV', 'BLV', 'RIN'))
                              AND (dbo.MAEVEN.ESPGVE <> 'C')
                              AND (dbo.MAEVEN.FEVE BETWEEN '$salidafechaIn' AND '$salidafechaOut')
                              AND dbo.MAEEDO.ENDO='10330844'
                            ORDER BY Rut, Numero,FVencimiento";
                    $sentencia = $con->prepare($nsql,[
                        PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
                    ]);
                    $sentencia->execute();
                    if (sizeof($sentencia->fetch(PDO::FETCH_ASSOC))>0) {
                      while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                            $fecha = new DateTime($row['Fecha']);
                            $fechaVencimiento = new DateTime($row['FVencimiento']);
                    ?>
                                <tr>
                                    <td>
                                      <p class="text-center"><?php echo $row['Tipo'];?></p>
                                      <p class="text-center"><?php echo $row['Numero']?></p>
                                    </td>
                                    <td><?php echo $row['Rut']?></td>
                                    <td><?php echo $row['RSocial']?></td>
                                    <td><?php echo $row['Direccion']?></td>
                                    <td>
                                      <p class="text-center"><?php echo $fecha->format("d/m/Y")?></p>
                                      <p class="text-center"><strong>$ <?php echo number_format($row['valorCompra'],0,",","."); ?></strong></p>
                                    </td>
                                    <td>
                                      <p class="text-center"><?php echo $fechaVencimiento->format("d/m/Y")?></p>
                                      <p class="text-center"><strong style="color: red;">$ <?php echo number_format($row['VCuota'],0,",","."); ?></strong></p>
                                    </td>
                                    <td> $ <?php echo number_format($row['Abono'],0,",","."); ?></td>
                                    <td> $ <?php echo number_format($row['VCuota'],0,",","."); ?></td>
                                    <td>
                                      <form action="#" method="POST">
                                        <div class="form-row">
                                          <div class="form-group col-md-12">
                                            <input type="text" class="form-control" id="telefonoContacto" name="telefonoContacto" value="<?php echo trim($row['Telefono']) ?>" placeholder="Telefono">
                                          </div>
                                        </div>
                                        <div class="form-row">
                                          <div class="form-group col-md-12">
                                            <input type="hidden" name="idCliente" value="<?php echo $row['Rut'] ?>">
                                            <input type="hidden" name="dateStart" value="<?php echo $salidafechaIn; ?>">
                                            <input type="hidden" name="dateEnd" value="<?php echo $salidafechaOut; ?>">
                                            <input type="text" class="form-control" id="correoContacto" name="correoContacto" value="" placeholder="e-mail">
                                          </div>
                                          <div class="form-group col-md-12 align-content-center">
                                            <div class="btn-group" role='group'>
                                              <button type="submit" formaction="/deudaPeriodoCliente.php" class="btn btn-danger"><i class="fas fa-file-pdf"></i></button>
                                              <button type="button" class="btn btn-primary" disabled="true"><i class="fas fa-envelope-square"></i></button>
                                              <!-- <button id="whatsapp" type="submit" class="btn btn-success" formaction="/whatsappCobranza.php">
                                                <i class="fab fa-whatsapp"></i>
                                              </button> -->
                                            </div>
                                          </div>
                                        </div>
                                      </form>
                                    </td>
                                </tr>
                    <?php
                        }
                    } else { ?>
                        <tr><td colspan="9">No hay registros con estos criterios</tr>
                    <?php }
                    $sentencia = null;
                    $con = null;
                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th scope="col"># DOC</th>
                    <th>Rut</th>
                    <th>Titular</th>
                    <th>Dirección</th>
                    <th scope="col" class="text-center">FECHA DOC</th>
                    <th scope="col" class="text-center">VENCIMIENTO CUOTA</th>
                    <th scope="col" class="text-center">ABONO</th>
                    <th scope="col" class="text-center">SALDO CUOTA</th>
                    <th>Contacto</th>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
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
      "language":{
        "decimal":        "",
        "emptyTable":     "No hay datos",
        "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
        "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
        "infoFiltered":   "(Filtro de _MAX_ total registros)",
        "infoPostFix":    "",
        "thousands":      ",",
        "lengthMenu":     "Mostrar _MENU_ registros",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search":         "Buscar:",
        "zeroRecords":    "No se encontraron coincidencias",
        "paginate": {
          "first":      "Primero",
          "last":       "Ultimo",
          "next":       "Próximo",
          "previous":   "Anterior"
        },
      "aria": {
          "sortAscending":  ": Activar orden de columna ascendente",
          "sortDescending": ": Activar orden de columna desendente"
        }
      }
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
