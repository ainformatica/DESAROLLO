<?php 

ob_start();
session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');

$usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];
$id = $_GET['id'];

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$fecha = $dt->format("Y/m/d");

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hora = $dt->format("H:i:s");

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$anio = $dt->format("Y");

$sql = "SELECT
t1.id_reunion,
t1.fecha,
t1.nombre_reunion,
t1.lugar,
t1.hora_inicio,
t1.hora_final,
t1.asunto,
t1.agenda_propuesta,
t1.enlace,
t2.estado_reunion,
t3.tipo, 
t1.mensaje,
t1.categoria
FROM
tbl_reunion t1
INNER JOIN tbl_estado_reunion t2 ON
t2.id_estado_reunion = t1.id_estado
INNER JOIN tbl_tipo_reunion_acta t3 ON
t3.id_tipo = t1.id_tipo
WHERE
id_reunion = $id ";
$resultado = $mysqli->query($sql);
$estado = $resultado->fetch_assoc();

$sql = "SELECT
GROUP_CONCAT(' -- ',t2.nombres, ' ', t2.apellidos) AS personas
FROM
tbl_participantes t1
INNER JOIN tbl_personas t2 ON
t2.id_persona = t1.id_persona
WHERE
id_reunion = $id";
$resultado = $mysqli->query($sql);
$personas = $resultado->fetch_assoc();



class PDF extends FPDF
	{
		function Header(){
			if ( $this->PageNo() == 1 ) {
							//date_default_timezone_get('America/Tegucigalpa');
		                   $this->Image('../dist/img/logo_ia.jpg', 12,8,30);
		                   $this->Image('../dist/img/logo-unah.jpg', 172,8, 22 );
				}
		}
function Footer()
		{
			$fecha_actual=date("Y-m-d H:i:s");
			$this->SetY(-15);
			$this->SetFont('Arial','I', 8);
			    // Go to 1.5 cm from bottom
				$this->SetY(-15);
				// Select Arial italic 8
				$this->SetFont('Arial','I',8);
				// Print current and total page numbers
				$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
		}	

}
//date_default_timezone_get('America/Tegucigalpa');

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d H:i:s");
$id_objetoac = 146;
$id_userac = $_SESSION['id_usuario'];
$accionac = 'REPORTE';
$descripcionac= 'generÓ reporte de memorÁndum de la reuniÓn con nombre: '.$estado['nombre_reunion'];
$fechaac = $hoy;
$stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
$stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
$stmt->execute();

$resultado = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($resultado);
	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática Administrativa'),0,1,'C');
	$pdf->ln(20);
	$pdf->SetFont('Arial','BU',15);
 	$pdf->cell(0,6,utf8_decode('MEMORÁNDUM IA-'.$estado['id_reunion'].'/'.$anio),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Arial','', 10);
	$pdf->ln(5);
	$pdf->Cell(0,5,utf8_decode('Fecha Impresión: '.$fecha."  ".$hora),0,1,'C');
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->ln(10);
	$pdf->SetX(20);
	$pdf->multicell(170,7,utf8_decode('Nombre Reunion: '. $estado['nombre_reunion']),0);
	$pdf->SetX(20);
	$pdf->multicell(170,7,utf8_decode('Categoria: '. $estado['categoria']),0);
	$pdf->SetX(20);
	$pdf->multicell(170,7,utf8_decode('Fecha: '. $estado['fecha']),0);
	$pdf->SetX(20);
	$pdf->multicell(170,7,utf8_decode('Lugar: ' . $estado['lugar']),0);
	$pdf->SetX(20);
	$pdf->multicell(170,7,utf8_decode('Modalidad: ' . $estado['tipo']),0);
	$pdf->SetX(20);
	$pdf->multicell(170,7,utf8_decode('De: Jefatura Depto. Informática Administrativa'),0);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','I',11);
	$pdf->multicell(170,7,utf8_decode('Para: '. $personas['personas']),0);
	$pdf->SetX(20);
	$pdf->SetFont('Arial','B',12);
	$pdf->multicell(170,7,utf8_decode('Asunto: ' . $estado['asunto']),0);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Link: ' ). $estado['enlace'],0);
	$pdf->SetX(20);
	$pdf->multicell(170,7,utf8_decode('Estado: ' . $estado['estado_reunion'].$estado['mensaje']),0);
	$pdf->ln(2);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(5);
	$pdf->SetX(20);
    $pdf->multicell(170,9,utf8_decode('Estimados: '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Por medio del presente se recuerda que el próximo '. $estado['fecha'] . ' se realizará la reunión con asunto '.$estado['asunto'].', en el horario de ' .$estado['hora_inicio'].' a ' .$estado['hora_final'].' con los siguientes puntos a tratar: '),0);
	$pdf->ln(5);
	$pdf->SetX(20);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',12);
	$pdf->ln(2);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode($estado['agenda_propuesta']),0);
	$pdf->SetX(20);
	$pdf->ln(2);
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','I',12);
	$pdf->ln(15);
	$pdf->SetX(20);
	$pdf->multicell(170,5,utf8_decode('Tegucigalpa MDC '.$fecha),0);
	$pdf->ln(5);
	$pdf->SetX(25);
	$pdf->Output('REPORTE_MEMORANDUM IA-'.$estado['id_reunion'].'/'.$anio.'.pdf', 'I');