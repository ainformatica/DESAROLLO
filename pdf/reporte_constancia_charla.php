<?php 

	 session_start();

require ('fpdf/fpdf.php');
require_once ('../clases/Conexion.php');

function fechaCastellano ($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
  $meses_ES = array("enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre");
    $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
    $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
    return $numeroDia." de ".$nombreMes." del ".$anio;
  }

  function fecha ($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $mes = date('F', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    return $numeroDia." de ".$nombreMes." del ".$anio;
  }

date_default_timezone_set('America/Tegucigalpa');
        $fecha = date('Y-m-d');

class PDF extends FPDF
{
    // Cabecera de página
	function Header()
    {
		// Logo
        $this->Image('../dist/img/logo.png',30,12,28);
        // Arial bold 15
        $this->SetFont('Arial','I',10);
        $this->SetFillColor(255, 255, 255);;
        // Movernos a la derecha
        $this->Rect(0,0,220,50,'F');
        $this->Image('../dist/img/encabezado.png',10,12,195);
        // Título
        $this->SetY(10);
        $this->SetX(164);
        $this->Write(15,utf8_decode('Fecha de'));
        $this->SetY(14);
        $this->SetX(163);
        $this->Write(15,utf8_decode('aprobación:'));
        $this->SetY(18.5);
        $this->SetX(163);
        $this->Write(15,utf8_decode('15/10/2021'));
        $this->SetY(10);
        $this->SetX(186);
        $this->Write(15,utf8_decode('Código:'));
        $this->SetY(14.3);
        $this->SetX(183);
        $this->SetFont('Arial','I',9);
        $this->Write(15,utf8_decode('UVIA-CPPS-'));
        $this->SetY(18);
        $this->SetX(189.5);
        $this->Write(15,utf8_decode('01'));
        $this->SetFont('Arial','I',10);
        $this->SetY(23);
        $this->SetX(172);
        $this->Write(15,utf8_decode('Versión 1.0'));
        $this->SetY(29);
        $this->SetX(168);
        $this->Write(15,utf8_decode('Fecha de emisión:'));
        $this->SetY(34);
        $this->SetX(173);
        $this->Write(15,utf8_decode('25/10/2021'));

        $this->Ln(20);
    }
} 
if (isset($_POST['id_persona']) ) {
    $id_persona=$_POST['id_persona'];

    $charla="SELECT  tbl_vinculacion_gestion_charla.id_charla FROM tbl_charla_practica
    INNER JOIN tbl_vinculacion_gestion_charla ON tbl_charla_practica.charla_id=tbl_vinculacion_gestion_charla.id_charla
    WHERE id_persona=$id_persona";

    $resultado= mysqli_fetch_assoc($mysqli->query($charla));
    $id_charla=$resultado['id_charla'];

    $fecha_sys=date_default_timezone_get();
    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
        $sqltabla="SELECT (SELECT  concat(tbl_personas.nombres,' ',  tbl_personas.apellidos) as nombre1
                    FROM tbl_vinculacion_gestion_charla INNER JOIN tbl_personas
                        ON tbl_vinculacion_gestion_charla.primer_expositor=tbl_personas.id_persona
                        INNER JOIN tbl_jornada_charla ON tbl_jornada_charla.id_jornada_charla = tbl_vinculacion_gestion_charla.id_jornada_charla
                    WHERE tbl_vinculacion_gestion_charla.estado = 1 and tbl_vinculacion_gestion_charla.id_charla in($id_charla)) as expo1 ,
            (SELECT concat(tbl_personas.nombres,' ',  tbl_personas.apellidos) as nombre2
                    FROM tbl_vinculacion_gestion_charla INNER JOIN tbl_personas
                    ON tbl_vinculacion_gestion_charla.segundo_expositor=tbl_personas.id_persona
                    INNER JOIN tbl_jornada_charla ON tbl_jornada_charla.id_jornada_charla = tbl_vinculacion_gestion_charla.id_jornada_charla
                    WHERE tbl_vinculacion_gestion_charla.estado = 1 
                    and tbl_vinculacion_gestion_charla.id_charla in($id_charla)) as expo2,
                    concat(tb1.nombres,' ',tb1.apellidos)AS nombre, tb2.valor , tb3.no_constancia, tb4.fecha_charla, periodo, tb4.fecha_valida from 
                    tbl_personas tb1 inner JOIN tbl_personas_extendidas tb2
                    on tb1.id_persona=tb2.id_persona
                    INNER JOIN tbl_charla_practica tb3
                    on tb1.id_persona=tb3.id_persona
                    INNER JOIN tbl_vinculacion_gestion_charla tb4
                    ON tb3.charla_id=tb4.id_charla

            WHERE tb3.estado_asistencia_charla=1  AND tb2.id_atributo=12 AND tb1.id_persona in($id_persona);";
    $row= mysqli_fetch_assoc($mysqli->query($sqltabla));
$fecha_charla=$row['fecha_charla'];
$fecha_valida=$row['fecha_valida'];
 
$pdf = new PDF('P','mm','letter',true);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->Image('../dist/img/fondo.png',1,70,217);
$pdf->cell(0,6,utf8_decode('CONSTANCIA'),0,1,'C');
$pdf->SetFont('Arial','B',12);
$pdf->ln(2);
$pdf->cell(0,6,utf8_decode('UVIA-'.$row['periodo'].'-'.$row['no_constancia'].' '),0,1,'C');
$pdf->ln(10);

$pdf->SetFillColor(232,232,232);
$pdf->SetFont('Arial','I',12);

$pdf->Image('../dist/img/cuadro.png',20,70,160);
$pdf->SetX(210);
$pdf->SetY(71);
$pdf->Cell(200, 10, ''.$row['nombre'].'', 0, 1, 'C');
$pdf->ln(-3);
$pdf->SetX(80);
$pdf->SetY(81);
$pdf->Cell(165, 10, utf8_decode(''.$row['valor'].''), 0, 1, 'C');
$pdf->ln(5);

$pdf->SetFillColor(232,232,232);
$pdf->SetX(20);
$pdf->multicell(170,7,utf8_decode('El Departamento de Informática de la Facultad de Ciencias Económicas, Administrativas y Contables de la Universidad Nacional Autónoma de Honduras (UNAH) a través de su Unidad de Vinculación Universidad - Sociedad, hace constar la participación del referido estudiante en el proceso de INDUCCIÓN SOBRE PRÁCTICA PROFESIONAL, realizada el '.fechaCastellano($fecha_charla).' e impartida por '.$row['expo1'].' y '.$row['expo2'].'.La presente constancia es válida hasta el '.fechaCastellano($fecha_valida).'.'),0);    
$pdf->ln(5);
$pdf->SetX(20); 
$pdf->multicell(170,7,utf8_decode('Se extiende la presente constancia en Ciudad Universitaria, Tegucigalpa, Honduras, el '.fechaCastellano($fecha).'.'),0);
$pdf->ln(32);
$pdf->Image('../dist/img/Sello.png',55,181,25);
$pdf->Image('../dist/img/firma.png',82,182,40);
$pdf->SetFont('Times','BI',14);
$pdf->cell(0,6,utf8_decode('Cristian Josué Rivera Ramírez'),0,1,'C');
$pdf->ln(2);
$pdf->SetFont('Times','I',14);
$pdf->cell(0,6,utf8_decode('Coordinador de Comité de Vinculación Universidad - Sociedad'),0,1,'C');
$pdf->ln(2);
$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');

$pdf->SetTitle('CONSTANCIA CHARLA '.$row['nombre'].'');

$pdf->Output('I','CONSTANCIA_CHARLA_PPS.pdf');
}

$carpeta='../Documentacion_practica/'.$row['valor'].'/';
if(!file_exists($carpeta)){
  mkdir($carpeta,0777,true);
 
}

  $pdf = new PDF('P','mm','letter',true);
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',16);
  $pdf->Image('../dist/img/fondo.png',1,70,217);
  $pdf->cell(0,6,utf8_decode('CONSTANCIA'),0,1,'C');
  $pdf->SetFont('Arial','B',12);
  $pdf->ln(2);
  $pdf->cell(0,6,utf8_decode('UVIA-'.$row['periodo'].'-'.$row['no_constancia'].' '),0,1,'C');
  $pdf->ln(10);
  
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetFont('Arial','I',12);
  
  $pdf->Image('../dist/img/cuadro.png',20,70,160);
  $pdf->SetX(210);
  $pdf->SetY(71);
  $pdf->Cell(200, 10, ''.$row['nombre'].'', 0, 1, 'C');
  $pdf->ln(-3);
  $pdf->SetX(80);
  $pdf->SetY(81);
  $pdf->Cell(165, 10, utf8_decode(''.$row['valor'].''), 0, 1, 'C');
  $pdf->ln(5);
  
  $pdf->SetFillColor(232,232,232);
  $pdf->SetX(20);
  $pdf->multicell(170,7,utf8_decode('El Departamento de Informática de la Facultad de Ciencias Económicas, Administrativas y Contables de la Universidad Nacional Autónoma de Honduras (UNAH) a través de su Unidad de Vinculación Universidad - Sociedad, hace constar la participación del referido estudiante en el proceso de INDUCCIÓN SOBRE PRÁCTICA PROFESIONAL, realizada el '.fechaCastellano($fecha_charla).' e impartida por '.$row['expo1'].' y '.$row['expo2'].'.La presente constancia es válida hasta el '.fechaCastellano($fecha_valida).'.'),0);    
  $pdf->ln(5);
  $pdf->SetX(20); 
  $pdf->multicell(170,7,utf8_decode('Se extiende la presente constancia en Ciudad Universitaria, Tegucigalpa, Honduras, el '.fechaCastellano($fecha).'.'),0);
  $pdf->ln(32);
  $pdf->Image('../dist/img/Sello.png',55,181,25);
  $pdf->Image('../dist/img/firma.png',82,182,40);
  $pdf->SetFont('Times','BI',14);
  $pdf->cell(0,6,utf8_decode('Cristian Josué Rivera Ramírez'),0,1,'C');
  $pdf->ln(2);
  $pdf->SetFont('Times','I',14);
  $pdf->cell(0,6,utf8_decode('Coordinador de Comité de Vinculación Universidad - Sociedad'),0,1,'C');
  $pdf->ln(2);
  $pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');
  
  $pdf->SetTitle('CONSTANCIA CHARLA '.$row['nombre'].'');
  
  $pdf->Output('F','../Documentacion_practica/'.$row['valor'].'/01_CONSTANCIA_CHARLA_PPS.pdf');




?>