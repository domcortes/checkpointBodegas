
<?php
require('pdf/fpdf.php');
require_once('panel/php/clases/cc2.php');
$rutCliente=$_POST['idCliente'];

//validacion de cliente con rut posteado
if ($rutCliente==="") {
  header('Location: /panel/home.php');
  ob_end_flush();
  exit();
}
// 2 0 2 1       0 1        0 1
// 0 1 2 3       4 5        6 7
// anno          mes        dia

$startDateSQL = $_POST['dateStart'];
$endDateSQL = $_POST['dateEnd'];
$dateStart = substr($startDateSQL, 6, 2).'-'.substr($startDateSQL, 4, 2).'-'.substr($startDateSQL, 0, 4);
$dateEnd = substr($endDateSQL, 6, 2).'-'.substr($endDateSQL, 4, 2).'-'.substr($endDateSQL, 0, 4);
$dateFileNameIn = substr($startDateSQL, 6, 2).'_'.substr($startDateSQL, 4, 2).'_'.substr($startDateSQL, 0, 4);
$dateFileNameOut = substr($endDateSQL, 6, 2).'_'.substr($endDateSQL, 4, 2).'_'.substr($endDateSQL, 0, 4);

class PDF extends FPDF {
  function Header(){
      // Movernos a la derecha
      $this->Cell(80);
      // Título
      $this->SetFont('Arial','B',25);
      $this->Cell(30,10,'Estado de cuenta',0,0,'C');
      $this->Image('images/main.png',10,8,15);
      // Salto de línea

      $this->Ln(20);
  }

  function Footer(){
      // Posición: a 1,5 cm del final
      $this->SetY(-15);
      // Arial italic 8
      $this->SetFont('Arial','I',8);
      // Número de página
      $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
  }

  public function gaficoPDF($datos = array(),$nombreGrafico = NULL,$ubicacionTamamo = array(),$titulo = NULL) {

    if(!is_array($datos) || !is_array($ubicacionTamamo)){
     echo "los datos del grafico y la ubicacion deben de ser arreglos";
    }
    elseif($nombreGrafico == NULL){
     echo "debe indicar el nombre del grafico a crear";
    }
    else{
     #obtenemos los datos del grafico
     foreach ($datos as $key => $value){
      $data[] = $value[0];
      $nombres[] = $key;
      $color[] = $value[1];
     }
     $x = $ubicacionTamamo[0];
     $y = $ubicacionTamamo[1];
     $ancho = $ubicacionTamamo[2];
     $altura = $ubicacionTamamo[3];
     #Creamos un grafico vacio
     $graph = new PieGraph(600,400);
     #indicamos titulo del grafico si lo indicamos como parametro
     if(!empty($titulo)){
      $graph->title->Set($titulo);
     }
     //Creamos el plot de tipo tarta
     $p1 = new PiePlot3D($data);
     $p1->SetSliceColors($color);
     #indicamos la leyenda para cada porcion de la tarta
     $p1->SetLegends($nombres);
     //Añadirmos el plot al grafico
     $graph->Add($p1);
     //mostramos el grafico en pantalla
     $graph->Stroke("$nombreGrafico.png");
     $this->Image("$nombreGrafico.png",$x,$y,$ancho,$altura);
    }
   }
}

$pdf = new PDF('P','mm','Letter');
$pdf->SetFillColor(230,196,67);
$pdf->AliasNbPages();
$pdf->AddPage();


//identificacion del cliente
$pdf->SetFont('Arial','',8);
$tsql2= " SELECT distinct
              dbo.MAEEN.IDMAEEN AS IdCliente,
              dbo.MAEEN.NOKOEN AS RSocial,
              dbo.MAEEN.DIEN AS Direccion,
              dbo.MAEEN.FOEN AS Telefono,
              dbo.MAEEN.KOEN AS Rut,
              dbo.MAEEN.EMAIL AS Email,
              dbo.MAEEN.CRTO AS Cupo, dbo.MAEEN.SUEN AS Adicional
          FROM dbo.MAEEN
          WHERE dbo.MAEEN.KOEN ='$rutCliente'
            AND dbo.MAEEN.SUEN =''
          ORDER BY dbo.MAEEN.IDMAEEN";
$sentencia = $con->prepare($tsql2,[PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,]);
$sentencia->execute();
$datosCliente = $sentencia->fetch(PDO::FETCH_ASSOC);

//tabla presentacion cliente
  $pdf->Cell(45,6,'Nombre Cliente',1,0,'L',0);
  $pdf->Cell(150,6,$datosCliente['RSocial'],1,1,'L',0);
  $pdf->Cell(45,6,'Direccion',1,0,'L',0);
  $pdf->Cell(150,6,$datosCliente['Direccion'],1,1,'L',0);
  $pdf->Cell(45,6,'Telefono',1,0,'L',0);
  $pdf->Cell(150,6,$datosCliente['Telefono'],1,1,'L',0);
  $pdf->Cell(45,6,'Correo electronico',1,0,'L',0);
  $pdf->Cell(150,6,$datosCliente['Email'],1,1,'L',0);
  $pdf->Cell(45,6,utf8_decode('Número Cliente'),1,0,'L',0);
  $pdf->Cell(150,6,$datosCliente['Rut'],1,0,'L',0);
//-fin tabla presentacion cliente

$pdf->Ln(20);

//tabla de detalle general//
  $pdf->SetFont('Arial','B',8);
  $pdf->Cell(195,6,'I. DETALLE GENERAL',1,1,'C',true);
  $pdf->Ln(2);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(25,6,'',0,0,'C',0);
  $pdf->Cell(35,6,'CUPO APROBADO',1,0,'C',0);
  $pdf->Cell(35,6,'CUPO UTILIZADO',1,0,'C',0);
  $pdf->Cell(35,6,'CUPO DISPONIBLE',1,0,'C',0);
  $pdf->Cell(15,6,'',0,0,'C',0);
  $pdf->Cell(50,6,'PERIODO FACTURADO',1,1,'C',0);
  $pdf->Cell(25,6,'CUPO TOTAL',1,0,'C',0);
  $pdf->Cell(35,6,'$'.number_format($datosCliente['Cupo'],0,",","."),1,0,'C',0);

    //calculo gastos
    $tsql3 = "SELECT  TIDO,NUDO,ENDO,FEEMDO,FE01VEDO,ESPGDO,VABRDO,VAABDO,VABRDO-VAABDO AS SALDO
              FROM MAEEDO
              WHERE ESPGDO='P'
              AND ENDO = '$rutCliente'
              ORDER BY FEEMDO ASC;";

    $sentencia2 = $con->prepare($tsql3,[
      PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
    ]);
    $sentencia2->execute();
    $montoGastos = 0;
    while ($dataGastos = $sentencia2->fetch(PDO::FETCH_ASSOC)) {
      if ($dataGastos['TIDO']==='NCV') {
          $montoGastos = $montoGastos - $dataGastos['SALDO'];
        } else {
          $montoGastos = $montoGastos + $dataGastos['SALDO'];
        }
    }
    //-fin calculo gastos

    $pdf->Cell(35,6,'$'.number_format($montoGastos,0,",","."),1,0,'C',0);
    $cupoDisponible = $datosCliente['Cupo']-$montoGastos;

if ($cupoDisponible<0) {
  $pdf->SetTextColor(255,0,0);
}
$pdf->Cell(35,6,'$'.number_format($cupoDisponible,0,",","."),1,0,'C',0);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(15,6,'',0,0,'C',0);
$pdf->Cell(25,6,$dateStart,1,0,'C',0);
$pdf->Cell(25,6,$dateEnd,1,0,'C',0);

//-termino tabla detalle general


//inicio detalle de cuotas
$pdf->Ln(15);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(195,6,'II. DETALLE FACTURACION MES',1,1,'C',true);
$pdf->SetFont('Arial','',8);
$pdf->Cell(40,6,'DOCUMENTO',1,0,'C',0);
$pdf->Cell(30,6,'FECHA DOC',1,0,'C',0);
$pdf->Cell(30,6,'VCTO CUOTA',1,0,'C',0);
$pdf->Cell(30,6,'VALOR CUOTA',1,0,'C',0);
$pdf->Cell(30,6,'ABONO',1,0,'C',0);
$pdf->Cell(35,6,'VALOR CUOTA MES',1,1,'C',0);
//consultar cuotas
$montoMes=0;
$tsql = "SELECT DISTINCT
              TOP (100) PERCENT
                dbo.MAEEN.NOKOEN AS RSocial,
                dbo.MAEEN.DIEN AS Direccion,
                dbo.MAEEN.FOEN AS Telefono,
                dbo.MAEEN.KOEN AS Rut,
                dbo.MAEEN.EMAIL AS Email,
                dbo.MAEEDO.TIDO AS Tipo,
                dbo.MAEEDO.NUDO AS Numero,
                dbo.MAEEDO.FEEMDO AS Fecha,
                dbo.MAEVEN.FEVE AS FVencimiento,
                dbo.MAEEDO.ESPGDO AS Estado,
                datediff(day,dbo.MAEEDO.FEEMDO,dbo.MAEVEN.FEVE) AS DIAS,
                dbo.MAEVEN.ESPGVE, dbo.MAEEDO.VABRDO AS valorCompra,
                dbo.MAEVEN.VAVE AS VCuota,
                dbo.MAEVEN.VAABVE AS Abono,
                dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS PorPagar
            FROM dbo.MAEEDO
            INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN AND dbo.MAEEDO.SUENDO = dbo.MAEEN.SUEN
            RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
            WHERE (dbo.MAEEDO.TIDO IN ('FCV', 'BLV', 'RIN'))
              AND (dbo.MAEVEN.ESPGVE <> 'C')
              AND (dbo.MAEVEN.FEVE BETWEEN '$startDateSQL' AND '$endDateSQL')
              AND dbo.MAEEDO.ENDO='$rutCliente'
            ORDER BY Rut, Numero,FVencimiento";
$sentencia3 = $con->prepare($tsql,[
  PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
]);
$sentencia3->execute();

while ($row = $sentencia3->fetch(PDO::FETCH_ASSOC)) {
  $montoMes = $montoMes+$row['PorPagar'];
  $pdf->Cell(40,6,$row['Tipo'].' '.$row['Numero'],1,0,'C',0);
    $fecha = new DateTime($row['Fecha']);
  $pdf->Cell(30,6,$fecha->format('d/m/Y'),1,0,'C',0);
    $FVencimiento = new DateTime($row['FVencimiento']);
  $pdf->Cell(30,6,$FVencimiento->format('d/m/Y'),1,0,'C',0);
  $pdf->Cell(30,6,'$'.number_format($row['VCuota'],0,",","."),1,0,'C',0);
  $pdf->Cell(30,6,'$'.number_format($row['Abono'],0,",","."),1,0,'C',0);
  $pdf->Cell(35,6,'$'.number_format($row['PorPagar'],0,",","."),1,1,'C',0);
}

$totalFacturado = $montoMes;

$pdf->SetFont('Arial','B',12);
$pdf->Cell(160,6,'MONTO TOTAL PERIODO FACTURADO: ',1,0,'R',0);
$pdf->Cell(35,6,'$'.number_format($totalFacturado,0,",","."),1,1,'C',0);
$pdf->Ln(10);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(195,6,'III. PROXIMOS VENCIMIENTOS',1,1,'C',true);
$pdf->Ln(2);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,6,'MONTO DEUDA',1,0,'C',0);

$conteoVencimientos = 1;
$mesVencimientoProximo = (int)substr($startDateSQL, 4, 2) + 1;
$añoVencimientoProximo = (int)substr($startDateSQL, 0, 4);
$vencimientosArray = array();
while($conteoVencimientos<=4){
    if ($mesVencimientoProximo>12) {
        $mesVencimientoProximo=1;
        $añoVencimientoProximo++;
    }
    if ($mesVencimientoProximo<10) {
      $newSQLStart = $añoVencimientoProximo.'0'.$mesVencimientoProximo.'01';
      $newSQLEnd = $añoVencimientoProximo.'0'.$mesVencimientoProximo.cal_days_in_month(CAL_GREGORIAN, $mesVencimientoProximo, $añoVencimientoProximo);
    }else {
      $newSQLStart = $añoVencimientoProximo.$mesVencimientoProximo.'01';
      $newSQLEnd = $añoVencimientoProximo.$mesVencimientoProximo.cal_days_in_month(CAL_GREGORIAN, $mesVencimientoProximo, $añoVencimientoProximo);
    }

    array_push($vencimientosArray, $newSQLStart);
    array_push($vencimientosArray, $newSQLEnd);
    $pdf->Cell(25,6,$mesVencimientoProximo."/".$añoVencimientoProximo,1,0,'C',0);
    $mesVencimientoProximo++;
    $conteoVencimientos++;
}

$pdf->Cell(15,6,'',0,0,'C',0);
$pdf->Cell(50,6,'PROX PERIODO FACTURACION',1,1,'C',0);

$pdf->Cell(30,6,'$'.number_format($montoGastos,0,",","."),1,0,'C',0);


//calculo cuatro meses
$conteoVencimientos = 1;
$i=0;
$j=1;
while ($conteoVencimientos<=4) {
  $montoMes=0;
  $nsql= "SELECT DISTINCT dbo.MAEEDO.TIDO AS Tipo, dbo.MAEEDO.NUDO AS Numero, dbo.MAEEDO.FEEMDO AS Fecha, dbo.MAEEDO.ESPGDO AS Estado,
                          dbo.MAEVEN.FEVE AS FVencimiento, dbo.MAEVEN.ESPGVE, dbo.MAEEDO.VABRDO AS Bruto, dbo.MAEVEN.VAABVE AS Abono,
                          dbo.MAEVEN.VAVE AS VCuota, dbo.MAEVEN.VAVE - dbo.MAEVEN.VAABVE AS SALDO
          FROM dbo.MAEEDO
            INNER JOIN dbo.MAEEN ON dbo.MAEEDO.ENDO = dbo.MAEEN.KOEN
            RIGHT OUTER JOIN dbo.MAEVEN ON dbo.MAEEDO.IDMAEEDO = dbo.MAEVEN.IDMAEEDO
          WHERE (dbo.MAEEDO.TIDO IN ('FCV', 'BLV','RIN')) -- AND (dbo.MAEEDO.ESPGDO = 'P')
            AND (dbo.MAEVEN.ESPGVE <> 'C')
            AND (dbo.MAEVEN.FEVE BETWEEN '$vencimientosArray[$i]' AND '$vencimientosArray[$j]')
            AND (dbo.MAEEDO.ENDO = '$rutCliente')
          ORDER BY dbo.MAEVEN.FEVE ASC";
  $sentencia4 = $con->prepare($nsql,[
    PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
  ]);
$sentencia4->execute();


while ($row = $sentencia4->fetch(PDO::FETCH_ASSOC)) {
  $montoMes = $montoMes+$row['SALDO'];
}
  $pdf->Cell(25,6,'$'.number_format($montoMes,0,",","."),1,0,'C',0);
  $conteoVencimientos++;
  $i = $i + 2;
  $j = $j + 2;
}

$pdf->Cell(15,6,'',0,0,'C',0);

$nextMonth = (int)substr($startDateSQL, 4, 2) + 1;
$year = (int)substr($startDateSQL, 0, 4);
if ($nextMonth>12) {
  $nextMonth = 1;
  $year = (int)substr($startDateSQL, 0, 4) + 1;
}

$lastDayNext = cal_days_in_month(CAL_GREGORIAN, $nextMonth, $year);

$dateStartNext = '01-'.$nextMonth.'-'.$year;
$dateEndNext = $lastDayNext.'-'.$nextMonth.'-'.$year;

$pdf->Cell(25,6,$dateStartNext,1,0,'C',0);
$pdf->Cell(25,6,$dateEndNext,1,0,'C',0);

$sentencia = null;
$sentencia2 = null;
$sentencia3 = null;
$sentencia4 = null;

$con = null;

//pagina con los datos de transferencia
$pdf->AddPage();
//tabla presentacion cliente
  $pdf->SetFont('Arial','B',15);
  $pdf->Cell(195,6,'FORMAS DE PAGO',0,1,'C',0);
  $pdf->Ln(10);
  $pdf->SetFont('Arial','i',10);
  $pdf->Cell(195,6,'Transferencia Bancaria',1,1,'C',0);
  $pdf->SetFont('Arial','',8);
  $pdf->Cell(45,6,'Nombre Titular',1,0,'L',0);
  $pdf->Cell(150,6,'Comercial Chelech S.A.',1,1,'L',0);
  $pdf->Cell(45,6,'Banco',1,0,'L',0);
  $pdf->Cell(150,6,'Santander',1,1,'L',0);
  $pdf->Cell(45,6,'Rut Titular',1,0,'L',0);
  $pdf->Cell(150,6,'76.415.150-K',1,1,'L',0);
  $pdf->Cell(45,6,'Correo electronico',1,0,'L',0);
  $pdf->Cell(150,6,'',1,1,'L',0);
  $pdf->Cell(45,6,'Numero de cuenta',1,0,'L',0);
  $pdf->Cell(150,6,'052-77-698',1,0,'L',0);
//-fin tabla presentacion cliente
  $pdf->Ln(15);


$pdf->Output('d','Cartola cliente '.$datosCliente['RSocial'].' periodo '.$dateFileNameIn.' al '.$dateFileNameOut.'.pdf', true);
?>