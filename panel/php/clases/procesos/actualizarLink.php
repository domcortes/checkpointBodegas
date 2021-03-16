<?php
	session_start();
	if (!$_SESSION['verificar']) {
		header("Location: /html/notAllowed.html");
	}else {
		require_once "../Conexion.php";
		require_once "../crudTeleventa.php";

		$idCode = $_POST['idurl'];
		$boleta = "";
		if (isset($_POST['nudo'])) {
			$boleta = $_POST['nudo'];
		}

		$tido = $_POST['tido'];
		$vatra = base64_decode(base64_decode(base64_decode($idCode)));

		echo "boleta ".$boleta."<br>";
		echo "tido ".$tido."<br>";
		echo "vatra ".$vatra;


		if ($boleta == "" && $tido == "SCO") {
			$boleta = 0;
			$busqueda = new metodosTeleventaLocal();
			$sql = "SELECT * from url where idUrl = '$vatra'";
			$buscarUrl = $busqueda->buscarURLlocal($sql);
			if (sizeof($buscarUrl)===1) {
				$datos = array(
					$boleta, $tido, $vatra
				);
				if ($busqueda->ingresarDocumentoUrl($datos)) {
					header("Location: /panel/pages/tables/televenta/listadoLinks.php");
					ob_end_flush();
					exit;
				} else {
					echo '<script>alert("No se puede actualizar, redireccionando..."); window.location="/panel/pages/tables/televenta/listadoLinks.php"</script>';
				}
			}


		} else if ($boleta ==="" && $tido === 'not'){
			echo
            	'<script>
                	alert("Debes seleccionar un tipo de documento valido e/o ingresar un numero de documento.");
                	window.location="/panel/pages/tables/televenta/listadoLinks.php";
            	</script>';
		} else {
			$busqueda = new metodosTeleventaLocal();
			$sql = "SELECT * FROM url where idUrl = '$vatra'";
			$buscarUrl = $busqueda->buscarURLlocal($sql);
			if (sizeof($buscarUrl)===1) {
				$datos = array(
					$boleta,
					$tido,
					$vatra
				);
				if ($busqueda->ingresarDocumentoUrl($datos)) {
					header("Location: /panel/pages/tables/televenta/listadoLinks.php");
					ob_end_flush();
					exit;
				}
			} else {
				echo '<script>alert("No se puede actualizar, redireccionando..."); window.location="/panel/pages/tables/televenta/listadoLinks.php"</script>';
			}
		}

	}

?>