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
  <title>AdminLTE 3 | Validation Form</title>
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
                <h3 class="card-title">ACTUALIZACIÓN DE USUARIO</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
                $obj = new metodos();
                $sql ="SELECT * FROM usuarios where idusuario='$idUsuario'";
                $datoUsuario = $obj->mostrarDatos($sql);
              ?>
              <form role="form" id="quickForm">
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre Usuario</label>
                    <input type="text" name="username" class="form-control" id="username" disabled="disabled" value="<?php echo ucwords($datoUsuario[0]['nombreUsuario']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Rut</label>
                    <input type="text" name="rut" class="form-control" id="rut" disabled="disabled" value="<?php echo ucwords($datoUsuario[0]['rutUsuario']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre Acceso</label>
                    <input type="text" name="accessname" class="form-control" id="accessname" disabled="disabled" value="<?php echo ($datoUsuario[0]['usuarioAcceso']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo ($datoUsuario[0]['correoElectronico']); ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Contraseña Actual</label>
                    <input type="password" name="oldPassword" class="form-control" id="oldPassword" placeholder="Ingrese su contraseña actual">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Nueva Contraseña</label>
                    <input type="password" name="newPassword" class="form-control" id="newPassword" placeholder="Ingrese una nueva contraseña">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Repetir Nueva Contraseña</label>
                    <input type="password" name="rptNewPassword" class="form-control" id="rptNewPassword" placeholder="Repita la nueva contraseña ingresada">
                  </div>
                  <div class="form-group mb-0">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="checkChangePass" class="custom-control-input" id="checkChangePass">
                      <label class="custom-control-label" for="checkChangePass"><a href="">Solo marcar si quiere cambiar contraseña</a></label>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <input type="submit" name="" id="" value="Actualizar datos usuario" class="btn btn-primary">
                </div>
              </form>
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
