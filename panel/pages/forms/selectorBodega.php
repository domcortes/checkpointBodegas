<?php

  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $idUsuario = $_SESSION['idUsuario'];
    $rolUsuario = $_SESSION['nivelAcceso'];
    require_once("../../php/clases/Conexion.php");
	require_once("../../php/clases/cc2.php");
	require_once("../../php/clases/crud.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Selector de bodegas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
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
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">SELECCION DE BODEGA</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              	<form method="post" class="inline" id="formSelector" name="formSelector">
					<div class="form-group">
						<select name="bosel" id="bosel" class="form-control">
							<option value="">Seleccione una bodega</option>
							<?php
								$tsql= "SELECT EMPRESA,KOSU,KOBO, NOKOBO FROM TABBO WHERE EMPRESA IN ('01','02')";
								$sentencia2 = $con->prepare($tsql,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
								$sentencia2->execute();
								while ($row = $sentencia2->fetch(PDO::FETCH_ASSOC)) { ?>
									<option value="<?php echo $row['KOBO'];?>"><?php echo $row['KOBO'].' | '.$row['NOKOBO']?></option>
							<?php
								}
								$sentencia2 = null;
                    			$con = null;
							?>
						</select>
					</div>
					<input type="button" value="Consulta de stock" class="btn btn-success" id="completo" name="completo" onclick="document.formSelector.action = '../tables/productos.php'; document.formSelector.submit();">
					<input type="button" value="Seccion catalogo" class="btn btn-primary" id="soloStock" name="soloStock" onclick="document.formSelector.action = '../tables/productoStock.php'; document.formSelector.submit();">
				</form>
              </div>
              <div class="card-footer bg-danger">
              	<p><strong>Advertencia:</strong></p>
              	<p>Existen bodegas con una cantidad superior a 10.000 productos. Estas bodegas demoraran mas en su carga, por lo que se sugiere esperar el proceso para poder entregar datos fidedignos</p>
              </div>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
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
<!-- jquery-validation -->
<script src="../../plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../../plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<script type="text/javascript">
$(document).ready(function () {
  $.validator.setDefaults({
    submitHandler: function () {
      alert( "Form successful submitted!" );
    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
        minlength: 8
      },
    },
    messages: {
      email: {
        required: "Por favor ingrese un email",
        email: "Por favor ingrese un email válido"
      },
      password: {
        required: "Por favor ingrese una contraseña",
        minlength: "Tu contraseña debe tener al menos 8 caracteres"
      }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>


</body>
</html>
