<?php
if ($_POST) {
	require_once("clases/Conexion.php");
	require_once("clases/cc2.php");
	include("Mailer/src/PHPMailer.php");
	include("Mailer/src/SMTP.php");
	include("Mailer/src/Exception.php");

	$correoContacto = $_POST['correoContacto'];
	$rut = $_POST['rut'];
	$dateStart = $_POST['dateStart'];
	$dateEnd = $_POST['dateEnd'];
	$subject = 'Cartola Mensual Empresas Chelech';
	$fromemail = 'informatica@chelech.cl';
	$fromname ='Departamento de Informatica';
	$host = 'smtp.gmail.com';
	$port = '587';
	$SMTPAuth='login';
	$SMTPSecure='tls';
	$password = 'martin07081988';
	$destinatario = $correoContacto;

	$nsql= "SELECT DISTINCT
                            -- dbo.MAEEN.IDMAEEN AS IdCliente,
                            dbo.MAEEN.NOKOEN AS RSocial,
                            dbo.MAEEN.DIEN AS Direccion,
                            --dbo.MAEEN.FOEN AS Telefono,
                            dbo.MAEEN.KOEN AS Rut,
                            -- dbo.MAEEN.EMAIL AS Email,
                            dbo.MAEEDO.TIDO AS Tipo,
                            dbo.MAEEDO.NUDO AS Numero,
                            dbo.MAEEDO.FEEMDO AS Fecha,
                            dbo.MAEEDO.ESPGDO AS Estado,
                            dbo.MAEVEN.FEVE AS FVencimiento,
                            dbo.MAEVEN.ESPGVE, dbo.MAEEDO.VABRDO AS Bruto,
                            dbo.MAEVEN.VAABVE AS Abono,
                            dbo.MAEVEN.VAVE AS VCuota,
                            dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS SALDO
                          FROM dbo.MAEEDO
                            INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
                            RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
                          WHERE (dbo.MAEEDO.TIDO IN ('FCV', 'BLV','RIN')) -- AND (dbo.MAEEDO.ESPGDO = 'P')
                            AND (dbo.MAEVEN.ESPGVE <> 'C')
                            AND (dbo.MAEEN.KOEN = '$rut')
                            AND (dbo.MAEVEN.FEVE BETWEEN '20210101' AND '20210131')
                            --AND (dbo.MAEEDO.ENDO = '')
                          ORDER BY dbo.MAEEN.KOEN ASC, dbo.MAEVEN.FEVE ASC";
	$sentencia = $con->prepare($nsql,[
		PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
	]);

	$totalCuenta=0;
	$asunto = 'Cartola cuenta Empresas Chelech';
	$cuerpo = '<p>Estimado Cliente, en adjunto encontrara su estado de cuenta, correspondiente al periodo de facturacion</p><br>
		<table style="border:1px solid black">
			<tr style="border:1px solid black">
				<th style="border:1px solid black">Documento</th>
				<th style="border:1px solid black">Rut</th>
				<th style="border:1px solid black">Titular</th>
				<th style="border:1px solid black">Fecha<br>Monto Compra</th>
				<th style="border:1px solid black">Vencimiento<br>Monto Cuota</th>
				<th style="border:1px solid black">Abonos</th>
				<th style="border:1px solid black">Saldo</th>
			</tr>';
	$sentencia = $con->prepare($nsql,[
	    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
	]);
	$sentencia->execute();
	if (sizeof($sentencia->fetch(PDO::FETCH_ASSOC))>0) {
		while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
			$fecha = new DateTime($row['Fecha']);
			$fechaVencimiento = new DateTime($row['FVencimiento']);
			$cuerpo.= '
				<tr>
					<td style="border:1px solid black">
						<p class="text-center">'.$row['Tipo'].'</p>
						<p class="text-center">'.$row['Numero'].'</p>
					</td>
					<td style="border:1px solid black">'.$row['Rut'].'</td>
					<td style="border:1px solid black">'.$row['RSocial'].'</td>
					<td style="border:1px solid black">
					<p class="text-center">'.$fecha->format("d/m/Y").'</p>
					<p class="text-center"><strong>$ '.number_format($row['Bruto'],0,",",".").'</strong></p>
					</td>
					<td style="border:1px solid black">
						<p class="text-center">'.$fechaVencimiento->format("d/m/Y").'</p>
						<p class="text-center"><strong style="color: red;">$ '.number_format($row['VCuota'],0,",",".").'</strong></p>
					</td>
					<td style="border:1px solid black"> $ '.number_format($row['Abono'],0,",",".").'</td>
					<td style="border:1px solid black"> $ '.number_format($row['SALDO'],0,",",".").'</td>
				</tr>';
			$totalCuenta = $totalCuenta + $row['SALDO'];
		}
	}
	$cuerpo.='	<tr>
			<td colspan="3"><strong>Total a Pagar</strong><td>
			<td>$ '.number_format($totalCuenta,0,',','.').'</td>
		</tr>
	</table><br><p>Tenga en consideracion que los montos en cartola estan actualizados a la fecha de emision de este correo electronico.<br>
	Si ya pago su saldo pendiente, puede omitir este correo electronico.</p>';

	$sentencia = null;
	$con = null;

	$mail = new PHPMailer\PHPMailer\PHPMailer();
	$mail ->isSMTP();
	$mail->SMTPDebug = 0;
	$mail->Host = $host;
	$mail->Port = $port;
	$mail->SMTPAuth = $SMTPAuth;
	$mail->SMTPSecure = $SMTPSecure;
	$mail->Username = $fromemail;
	$mail->Password = $password;
	/*
	$mail->SMTPOptions = array(
	'ssl' => array(
	'verify_peer'=>false,
	'verify_peer_name'=>false,
	'allow_self_signed'=>true
	)
	);*/
	$mail->setFrom($fromemail, $fromname);
	$mail->addAddress($correoContacto);
	$mail->isHTML(true);
	$mail->Subject = $subject;
	$mail->Body = $cuerpo;

	if (!$mail->send()) {
		error_log("No se pudo enviar el correo");
	}
	echo $cuerpo;
	}
?>