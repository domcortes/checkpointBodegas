<!DOCTYPE html>
<html lang="en">
<head>
	<title>CHECKPOINT CHELECH - ACCESO CLIENTES</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="fontAwesome/css/all.css" rel="stylesheet"> <!--load all styles -->
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="/images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="/css/util.css">
	<link rel="stylesheet" type="text/css" href="/css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="/images/main.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" method="post" action="">
					<span class="login100-form-title">
						Confirma tus datos para continuar
					</span>

					<div class="wrap-input100 validate-input" data-validate = "Debe ingresar un rut válido">
						<input class="input100" type="text" name="Nombre" placeholder="Ingrese su nombre:">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Debe ingresar un rut válido">
						<input class="input100" type="text" name="rutSDV" placeholder="Rut sin dígito verificador">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fas fa-barcode"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Debe ingresar un rut válido">
						<input class="input100" type="text" name="direccion" placeholder="Ingrese su dirección">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fas fa-map-marked-alt"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Debe ingresar un rut válido">
						<input class="input100" type="number" name="telefono" placeholder="ingrese teléfono">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fas fa-phone-square"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Debe ingresar un rut válido">
						<input class="input100" type="email" name="email" placeholder="Correo Electronico">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fas fa-at"></i>
						</span>
					</div>

					<!--<div class="wrap-input100 validate-input" data-validate = "La contraseña debe ser ingresada">
						<input class="input100" type="password" name="pass" placeholder="Contraseña">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>-->

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Actualizar datos &nbsp;
							<i class="fas fa-hand-point-right"></i>
						</button>
					</div>

					<div class="text-center p-t-12">
						<!--<span class="txt1">
							¿Olvidaste tu
						</span>
						<a class="txt2" href="#">
							Usuario / Contraseña?
						</a>-->
					</div>

					<div class="text-center p-t-136">
					</div>
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor/bootstrap/js/popper.js"></script>
	<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="/vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="/js/main.js"></script>

</body>
</html>