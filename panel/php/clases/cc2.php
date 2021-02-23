<?php
	$contrasena = "CHELECH";
	$usuario = "CHELECH";
	$nombreDB = "CHELECH";
	$rutaServer = "192.168.1.160";

	try {
		$con = new PDO("sqlsrv:server=$rutaServer;database=$nombreDB",$usuario,$contrasena);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (Exception $e) {
		echo "Ocurrio un error con la base de datos: ".$e->getMessage();
	}
?>