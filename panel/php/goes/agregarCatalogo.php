<?php
if (isset($_POST['catalogo'])) {
	if($_POST['catalogo']==null){
		$bodega = $_POST['bodega'];
		echo '<script>
				alert("No has seleccionado un catalogo, por favor selecciona uno");
				window.location.href="../../pages/tables/productoStock.php?boselget='.$bodega.'"
			</script>';
				// 	echo "<script>
				// 	Swal.fire({
				// 	  icon: 'error',
				// 	  title: 'Ups!!',
				// 	  text: 'No has seleccionado un catalogo, debes elegir uno para continuar!',
				// 	})
				// </script";
	} else {
		require_once ("../clases/Conexion.php");
		require_once ("../clases/crudTeleventa.php");
		require_once ("../clases/crudTeleventaRemoto.php");

		$bodega = $_POST['bodega'];
		$catalogo = $_POST['catalogo'];
		$imagen = $_POST['imagen'];
		$sato = $_POST['sato'];
		$nombre = $_POST['nombre'];
		$descripcion = $_POST['descripcionProducto'];
		$precioVenta = $_POST['precioVenta'];
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
		}
	}
}
