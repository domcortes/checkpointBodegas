<?php
  session_start();
  if(!$_SESSION['verificar']){
    header("Location: /html/notAllowed.html");
  }else {
    ob_start();
    $rutCliente = $_SESSION['rutClienteSDV'];
    echo $rutCliente;
    require_once("../../panel/php/clases/Conexion.php");
    require_once("../../panel/php/clases/cc2.php");
    require_once("../../panel/php/clases/crud.php");
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Table V04</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>

	<div class="limiter">
		<div class="container-table100">
			<div class="wrap-table100">
				<div class="table100 ver5 m-b-110">
					<div class="table100-head">
						<table>
							<thead>
								<tr class="row100 head">
									<th class="cell100 column2"># Doc</th>
									<th class="cell100 column3">Fecha Compra</th>
									<th class="cell100 column5">Vcto Cuota</th>
									<th class="cell100 column6">Valor Compra</th>
									<th class="cell100 column7">Valor Cuota</th>
									<th class="cell100 column8">Abono</th>
									<th class="cell100 column9">Saldo Cuota</th>
								</tr>
							</thead>
						</table>
					</div>

					<div class="table100-body js-pscroll">
						<table>
							<tbody>
								<?php
								$tsql= "SELECT DISTINCT
									dbo.MAEEDO.TIDO AS Tipo,
	                          		dbo.MAEEDO.NUDO AS Numero,
	                          		dbo.MAEEDO.ENDO AS Rut,
	                          		dbo.MAEEN.NOKOEN AS RSocial,
	                          		dbo.MAEEN.DIEN AS Direccion,
	                          		dbo.MAEEN.FOEN AS Telefono,
	                          		dbo.MAEEN.EMAIL AS Email,
	                          		dbo.MAEEN.BLOQUEADO AS EstadoCredito,
	                          		dbo.MAEEDO.FEEMDO AS Fecha,
	                          		dbo.MAEEDO.ESPGDO AS Estado,
	                          		dbo.MAEVEN.FEVE AS FVencimiento,
	                          		dbo.MAEVEN.VAVE AS VCuota,
	                          		dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS SALDO,
	                          		dbo.MAEVEN.ESPGVE,
	                          		dbo.MAEEDO.VABRDO AS Bruto,
	                          		dbo.MAEVEN.VAABVE AS Abono,
	                          		dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS SALDO
		                        FROM dbo.MAEEDO
		                        INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
		                        RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
		                        WHERE
		                        	(dbo.MAEEDO.TIDO IN ('FCV', 'BLV'))
		                          	-- AND (dbo.MAEEDO.ESPGDO = 'P')
		                          	-- AND (dbo.MAEVEN.ESPGVE <> 'C')
		                        AND (dbo.MAEEDO.ENDO = '$rutCliente')
		                        AND (dbo.MAEVEN.FEVE BETWEEN '20201101' AND '20210131')
		                        ORDER BY dbo.MAEVEN.FEVE ASC";
		                    $sentencia = $con->prepare($tsql,[PDO::ATTR_CURSSOR=>PDO::CURSOR_SCROLL]);
		                    $sentencia->execute();
                    		while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
                     ?>
								<tr class="row100 body">
									<td class="cell100 column2"><?php echo ($row['Numero']); ?></td>
									<td class="cell100 column3"><?php echo date_format($row['Fecha'],'d-m-Y'); ?></td>
									<td class="cell100 column3"><?php echo date_format($row['FVencimiento'],'d-m-Y'); ?></td>
									<td class="cell100 column6"><?php echo ($row['Bruto']); ?></td>
									<td class="cell100 column7"><?php echo ($row['VCuota']); ?></td>
									<td class="cell100 column8"><?php echo ($row['Abono']); ?></td>
									<td class="cell100 column9"><?php echo ($row['SALDO']); ?></td>
								</tr>
					<?php } $sentencia =null; $con=null;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>


<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});


	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>