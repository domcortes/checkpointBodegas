<?php
if (isset($_POST['catalogo'])) {
	if($_POST['catalogo']=="nulo"){
		$bodega = $_POST['bodega'];
		echo '<script>
				Swal.fire({
				  icon: "error",
				  title: "Ups!!",
				  text: "No has seleccionado un catalogo, debes elegir uno para continuar!",
				})
			</script>';
		// echo '<script>
		// 		Swal.fire({
		// 		  icon: "error",
		// 		  title: "Ups!!",
		// 		  text: "No has seleccionado un catalogo, debes elegir uno para continuar!",
		// 		})
		// 	</script';
	} else {
		require_once ("../clases/Conexion.php");
		require_once ("../clases/crudTeleventa.php");
		require_once ("../clases/crudTeleventaRemoto.php");

		$bodega = $_POST['bodega'];
		$catalogo = $_POST['catalogo'];
		$descripcion = $_POST['descripcionProducto'];
		$imagen = $_POST['imagen'];
		$nombre = $_POST['nombre'];
		$precioVenta = $_POST['precioVenta'];
		$sato = $_POST['sato'];
		$idUsuario = "1";

		$datos = array(
						$catalogo,
						$imagen,
						$sato,
						$nombre,
						$descripcion,
						$precioVenta,
						$idUsuario
					);
		$obj = new metodosTeleventaLocal();
		if ($obj->agregarCatalogo($datos)) {
			echo "<script>
					Swal.fire({
					  icon: 'success',
					  title: 'Excelente!',
					  text: 'Agregaste este producto al catalogo!',
					})
				</script>";
		} else {
			echo "<script>
					Swal.fire({
					  icon: 'error',
					  title: 'Ups!',
					  text: 'No se pudo agregar al catalogo!',
					})
				</script>";
		}
	}
}
