<?php
	session_start();
	if(!$_SESSION['verificar']){
		header("Location: /html/notAllowed.html");
	}else {
		ob_start();
		$idUsuario = $_SESSION['idUsuario'];
		$rolUsuario = $_SESSION['nivelAcceso'];

		$monto = $_POST['amount'];
		$ordenCompra = $_POST['valeTransitorio'];
		$email = $_POST['email'];
		$telefono = $_POST['phone'];
		$empresa = $_POST['empresa'];

		if ($empresa==0) {
			echo
                '<script>
                    alert("No selecciono empresa, por favor complete los datos");
                </script>';
                header('Location: /panel/pages/forms/boton.php');
                ob_end_flush();
                exit();
		} else if ($monto =="" || $ordenCompra =="" || $email =="" || $telefono =="") {
			echo
                '<script>
                    alert("Hay campos vacios, por favor llene todos los campos");
                </script>';
                header('Location: /panel/pages/forms/boton.php');
                ob_end_flush();
                exit();
		} else {
			require_once ("../Conexion.php");
			require_once ("../crudTeleventa.php");
			require_once ("../crudTeleventaRemoto.php");

			$encodeAmount = base64_encode(base64_encode(base64_encode($monto)));
			$encodeOrder = base64_encode(base64_encode(base64_encode($ordenCompra)));
			$encodeMail = base64_encode(base64_encode(base64_encode($email)));
			$encodePhone = base64_encode(base64_encode(base64_encode($telefono)));

			$url = 'www.chelech.cl/payment.php?a='.$encodeAmount.'&o='.$encodeOrder.'&m='.$encodeMail.'&p='.$encodePhone.'&u='.$idUsuario;
			$boleta="0";
			$tido="not";
			$fechaCreacion = new DateTime("NOW");
			$fecha= $fechaCreacion->format('Y-m-d');

			$sql = "SELECT * from url where valeTransitorio='".$ordenCompra."'";
			$obj = new metodosTeleventaLocal();
			$result = $obj->buscarURLlocal($sql);
			if (sizeof($result)===0) {
				$datos = array(
					$url,
					$fecha,
					$boleta,
					$ordenCompra,
					$tido,
					$monto,
					$idUsuario
				);
				if ($obj->insertarURLlocal($datos)) {
						header('Location: /panel/pages/forms/botonDone.php?a='.$encodeAmount.'&o='.$encodeOrder.'&m='.$encodeMail.'&p='.$encodePhone.'&u='.$idUsuario);
						ob_end_flush();
						exit();
				} else {
					echo "fallo en el registro local";
				}
			} else {
				 echo
	                '<script>
	                    alert("URL ya existe, será redirigido hacia sección para copiar y pegar link");
	                </script>';
	                header('Location: /panel/pages/forms/botonDone.php?a='.$encodeAmount.'&o='.$encodeOrder.'&m='.$encodeMail.'&p='.$encodePhone.'&u='.$idUsuario);
	                ob_end_flush();
	                exit();
			}
		}

	}
?>