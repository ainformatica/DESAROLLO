<?php
session_start();

require '../pdf/fpdf/fpdf.php';
require_once ('../clases/Conexion.php');

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$fecha = $dt->format("Y/m/d");

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hora = $dt->format("H:i:s");

$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$anio = $dt->format("Y");

$sql="SELECT a.num_acta, r.categoria, tra.tipo ,a.fecha, r.lugar, r.hora_inicio, r.hora_final
FROM tbl_acta a
INNER JOIN tbl_reunion r ON r.id_reunion = a.id_reunion
INNER JOIN tbl_tipo_reunion_acta tra ON tra.id_tipo = r.id_tipo
WHERE a.id_acta = '$_GET[id]'";
$resultado = $mysqli->query($sql);
$datos = $resultado->fetch_assoc();

$sql="SELECT r.agenda_propuesta, r.nombre_reunion FROM tbl_acta a
INNER JOIN tbl_reunion r ON r.id_reunion = a.id_reunion
WHERE a.id_acta = '$_GET[id]'";
$resultado = $mysqli->query($sql);
$agen = $resultado->fetch_assoc();

$sql="SELECT a.desarrollo FROM tbl_acta a
WHERE a.id_acta = '$_GET[id]'";
$resultado = $mysqli->query($sql);
$des = $resultado->fetch_assoc();


$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d H:i:s");
$id_objetoac = 5005;
$id_userac = $_SESSION['id_usuario'];
$accionac = 'REPORTE';
$descripcionac= 'generÓ reporte de ACTA no. '.$datos['num_acta'].' de la reuniÓn con nombre: '.$agen['nombre_reunion'];
$fechaac = $hoy;
$stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
$stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
$stmt->execute();

class PDF extends FPDF
	{
		function Header(){
			if ( $this->PageNo() == 1 ) {
							//date_default_timezone_get('America/Tegucigalpa');
		                   $this->Image('../dist/img/logo_ia.jpg', 35,20,40);
		                   $this->Image('../dist/img/logo-unah.jpg', 280,20, 30);
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

$resultado = mysqli_query($connection, $sql);
	$row = mysqli_fetch_array($resultado);
	$pdf = new PDF('L','mm','legal');
	//Margenes izquierda, arriba, derecha
	$pdf->SetMargins(20, 20 , 30);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
	$pdf->cell(0,6,utf8_decode('Universidad Nacional Autónoma de Honduras'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Facultad de Ciencias Económicas'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática Administrativa'),0,1,'C');
	$pdf->ln(10);
	$pdf->SetFont('Arial','', 10);
	$pdf->ln(5);
	$pdf->Cell(0,5,utf8_decode('Fecha Impresión: '.$fecha.' ' .$hora),0,1,'C');
	$pdf->SetFillColor(232,232,232);
	$pdf->SetFont('Arial','B',14);
	$pdf->ln(5);
	
	$pdf->Cell(300, 10, "ACTA ".utf8_decode($datos['num_acta']), 0, 0, 'C');
	$pdf->ln();
	$pdf->ln();
   
	$pdf->SetX(90);
	$pdf->SetFont('Arial', 'B', 14);
	$pdf->Cell(110, 7, utf8_decode("Acta N°.     : ".$datos['num_acta']), 0, 0, 'L');
	$pdf->Cell(80, 7, utf8_decode("Fecha        : ".$datos['fecha']), 0, 0, 'L');
	$pdf->ln();

	$pdf->SetX(90);
	$pdf->Cell(110, 7, utf8_decode("Categoria  : ".$datos['categoria']), 0, 0, 'L');
	$pdf->Cell(80, 7, utf8_decode("Hora Inicio : ".$datos['hora_inicio']), 0, 0, 'L');
	$pdf->ln();

	$pdf->SetX(90);
	$pdf->Cell(110, 7, utf8_decode("Modalidad  : ".$datos['tipo']), 0, 0, 'L');
	$pdf->Cell(80, 7, utf8_decode("Hora Final  : ".$datos['hora_final']), 0, 0, 'L');
	$pdf->ln();
	$pdf->SetX(90);
	$pdf->Cell(110, 7, utf8_decode("Lugar         : ".$datos['lugar']), 0, 0, 'L');
	$pdf->ln();
	$pdf->ln();
	$pdf->ln(2);

	$pdf->Ln();
	$pdf->SetFont('Arial', 'B', 14);
	$pdf->SetX(30);
	$pdf->Cell(300, 7, utf8_decode('Agenda Propuesta:'), 0, 0, 'L');
	$pdf->ln();
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetX(30);
	$pdf->MultiCell(300, 7, utf8_decode($agen['agenda_propuesta']), 0, 'L');
	$pdf->ln();


    $pdf->SetFont('Arial', 'B', 14);
	$pdf->SetX(30);
    $pdf->Cell(350, 7, utf8_decode('Desarrollo de la Reunión:'), 0, 0, 'L');
    $pdf->ln();
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetX(30);
	$pdf->MultiCell(300, 7, utf8_decode($des['desarrollo']), 0, 'J');
	$pdf->ln();
	$pdf->ln(20);

	$pdf->SetFont('Arial', 'B', 14); 
	$pdf->SetX(20);
	$pdf->Cell(60, 7, utf8_decode('Acuerdos'), 0, 0, 'L');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 12);             
	$pdf->SetX(20);
	$pdf->Cell(100, 7, utf8_decode('Responsable'), 1, 0, 'C');
	$pdf->Cell(55, 7, utf8_decode('Nombre de Acuerdo'), 1, 0, 'C');
	$pdf->Cell(100, 7, utf8_decode('Descripción'), 1, 0, 'C');
	$pdf->Cell(30, 7, utf8_decode('F. Expiración'), 1, 0, 'C');
	$pdf->Cell(30, 7, utf8_decode('Estado'), 1, 0, 'C');
	$pdf->Ln();


	$sql="SELECT
	CONCAT_WS(' ', t3.nombres, t3.apellidos) nombres,
	t1.nombre_acuerdo,
	t1.descripcion,
	t1.fecha_expiracion,
	t2.estado_acuerdo
	FROM
	tbl_acuerdos t1
	INNER JOIN tbl_estado_acuerdo t2 ON
	t2.id_estado = t1.id_estado
	INNER JOIN tbl_personas t3 ON
	t3.id_persona = t1.id_participante
	WHERE
	t1.id_acta = '$_GET[id]'";
	$resultado = $mysqli->query($sql);

	while ($acuerdo = $resultado->fetch_assoc()){
		$pdf->SetX(20);
	$pdf->Cell(100, 7, utf8_decode($acuerdo['nombres']), 1, 0, 'L');
	$pdf->Cell(55, 7, utf8_decode($acuerdo['nombre_acuerdo']), 1, 0,'L');
	$pdf->Cell(100, 7, utf8_decode($acuerdo['descripcion']), 1, 0, 'L');
	$pdf->Cell(30, 7, utf8_decode($acuerdo['fecha_expiracion']), 1, 0, 'C');
	$pdf->Cell(30, 7, utf8_decode($acuerdo['estado_acuerdo']), 1, 0, 'C');            
	$pdf->Ln();
	}



	$pdf->Ln(20);        
	$pdf->SetFont('Arial', 'B', 14);  
	$pdf->SetX(50);
	$pdf->Cell(60, 7, utf8_decode('Archivos Adjuntos'), 0, 0, 'L');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 12);  
	$pdf->SetX(50);
	$pdf->Cell(200, 7, utf8_decode('Nombre del Archivo'), 1, 0, 'C');
	$pdf->Cell(65, 7, utf8_decode('Formato del Archivo'), 1, 0, 'C');
	$pdf->Ln();

	$sql="SELECT
	t1.id_acta,
	t1.nombre,
	t1.formato
	FROM
	tbl_acta_recursos t1
	WHERE
	id_acta = '$_GET[id];'";
	$resultado = $mysqli->query($sql);
	
	while ($archivos = $resultado->fetch_assoc()){
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetX(50);
	$pdf->Cell(200, 7, utf8_decode($archivos['nombre']), 1, 0, 'L');
	$pdf->Cell(65, 7, utf8_decode($archivos['formato']), 1, 0,'L');        
	$pdf->Ln();

	}
	$pdf->Ln(20);


	
	$pdf->SetX(50);
	$pdf->SetFont('Arial', 'B', 14);
	$pdf->Cell(60, 7, utf8_decode("Promedio de Asistencia"), 0, 0, 'C');
	$pdf->Ln();
	$pdf->SetFont('Arial', '', 12);
	$pdf->SetLineWidth(0.3);
	$pdf->SetX(50);
	$pdf->Cell(70, 7, utf8_decode("N°. Acta"), 1, 0, 'C');
	$pdf->Cell(75, 7, utf8_decode("Nombre reunión"), 1, 0, 'C');
	$pdf->Cell(40, 7, "Asistencia", 1, 0, 'C');
	$pdf->Cell(40, 7, "Inasistencia", 1, 0, 'C');
	$pdf->Cell(40, 7, "Excusado", 1, 0, 'C');
	$pdf->ln();

	$sql="SELECT t1.id_reunion, t1.num_acta, t3.nombre_reunion,
			ROUND(SUM(t2.id_estado_participante = 1) / COUNT(t2.id_persona) * 100) AS asistio,
			ROUND(SUM(t2.id_estado_participante = 2) / COUNT(t2.id_persona) * 100) AS inasistencia,
			ROUND(SUM(t2.id_estado_participante = 3) / COUNT(t2.id_persona) * 100) AS excusa
			FROM  tbl_acta t1
			INNER JOIN tbl_participantes t2 ON  t2.id_reunion = t1.id_reunion
			INNER JOIN tbl_reunion t3 ON t3.id_reunion = t1.id_reunion
			WHERE t1.id_acta = '$_GET[id];'";
	$resultado = $mysqli->query($sql);	
	$total_asistencia = $resultado->fetch_assoc();

		$pdf->SetX(50);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(70, 7, utf8_decode($total_asistencia['num_acta']), 1, 0, 'C');
        $pdf->Cell(75, 7, utf8_decode($total_asistencia['nombre_reunion']), 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode($total_asistencia['asistio']). '%', 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode($total_asistencia['inasistencia']). '%', 1, 0, 'C');
        $pdf->Cell(40, 7, utf8_decode($total_asistencia['excusa']). '%', 1, 0, 'C');
        $pdf->ln();
        $pdf->ln(20);

       

		$pdf->SetFont('Arial', 'B', 14);
        $pdf->SetX(50);
        $pdf->Cell(60, 7, 'Lista de Participantes', 0, 0, 'L');
        $pdf->ln();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetLineWidth(0.3);
        $pdf->SetX(50);
        $pdf->Cell(105, 7, "Nombres", 1, 0, 'C');
        $pdf->Cell(70, 7, "Estado Asistencia", 1, 0, 'C');
        $pdf->Cell(90, 7, "Firma", 1, 0, 'C');
        $pdf->ln();

		$sql="SELECT concat_ws(' ', pe.nombres, pe.apellidos)nombres, (ep.estado)'asistencia' 
                FROM tbl_acta a 
                INNER JOIN tbl_participantes pa ON pa.id_reunion = a.id_reunion
                INNER JOIN tbl_personas pe ON pe.id_persona = pa.id_persona
                INNER JOIN tbl_estado_participante ep ON ep.id_estado = pa.id_estado_participante
                WHERE a.id_acta= '$_GET[id];'";
		$resultado = $mysqli->query($sql);

		while ($lista = $resultado->fetch_assoc()){

			$pdf->SetX(50);
			$pdf->SetFont('Arial', '', 12);
			$pdf->Cell(105, 15, utf8_decode($lista['nombres']), 1, 0, 'L');
			$pdf->Cell(70, 15, utf8_decode($lista['asistencia']), 1, 0, 'C');
			$pdf->Cell(90, 15, '', 1, 0, 'C');
			$pdf->ln();
		}		
		$pdf->ln();
		$pdf->ln();
		$pdf->ln();
		$pdf->ln();
		$pdf->ln();


		$pdf->SetX(90);
	$pdf->SetFont('Arial', 'B', 14);
	$pdf->Cell(110, 7, utf8_decode("----------------------------------------"));
	$pdf->Cell(80, 7, utf8_decode("-----------------------------------------"));
	$pdf->ln();

	$pdf->SetX(90);
	$pdf->Cell(110, 7, utf8_decode("FIRMA Y SELLO JEFE/A"));
	$pdf->Cell(80, 7, utf8_decode("FIRMA Y SELLO SECRETARIO/A"));
	$pdf->ln();
	$pdf->SetX(20);
	$pdf->ln(5);
	$pdf->SetX(25);
	$pdf->Output('ACTA '.$datos['num_acta'].'.pdf', 'I');
    ?>