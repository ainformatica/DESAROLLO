<?php 

	 session_start();

require 'fpdf/fpdf.php';
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

$usuario=$_SESSION['id_usuario'];
        $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
       $result= mysqli_fetch_assoc($mysqli->query($id));
       $id_persona=$result['id_persona'];
/* Manda a llamar todos las datos de la tabla para llenar el gridview  */
$sqltabla="Select ep.nombre_empresa, ep.jefe_inmediato, na.descripcion AS nivela ,ep.cargo_jefe_inmediato, concat(p.nombres,' ',p.apellidos)AS nombre, px.valor from tbl_empresas_practica ep, tbl_personas p, tbl_personas_extendidas px, tbl_nivel_academico na where ep.id_persona=p.id_persona and p.id_persona=$id_persona AND px.id_atributo=12 and px.id_persona=237 and ep.id_nivel_a=na.id_nivel_a";


class PDF extends FPDF
	{
		function Header()
		{
			//date_default_timezone_get('America/Tegucigalpa');
		    $this->Image('../dist/img/logos.png', 20,8,100);
			$this->Ln(30);
		}

}
// date_default_timezone_get('America/Tegucigalpa');

    $resultado = mysqli_query($connection, $sqltabla);
	$row = mysqli_fetch_array($resultado);

	

	$pdf = new PDF('P','mm','Legal',true);
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->Image('../dist/img/fondo.png',1,146,217);
    $pdf->SetX(22);
	$pdf->cell(0,6,utf8_decode('Tegucigalpa, MDC, '.fechaCastellano($fecha).''),0,1,'L');
// 	
    $pdf->SetFont('Arial','B',12);
    $pdf->SetY(50);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode(''.$row['nivela'].' |'.' '.$row['jefe_inmediato'].' '));
    $pdf->SetY(55);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode(''.$row['cargo_jefe_inmediato'].''));
    $pdf->SetY(60);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode(''.$row['nombre_empresa'].' '));
    $pdf->SetY(65);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode('SU OFICINA'));
	$pdf->ln(14);
    $pdf->SetFillColor(255, 255, 255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(22);
    $pdf->multicell(175,6,utf8_decode('Aprovecho la ocasión para extenderle un cordial saludo, acompañado de mis mejores deseos para su vida personal y profesional.'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Me dirijo a usted para presentar a '.$row['nombre'].', con número de cuenta '.$row['valor'].', estudiante de la carrera de Informática Administrativa de la Facultad de Ciencias Económicas, Administrativas y Contables de la Universidad Nacional Autónoma de Honduras (UNAH), a fin de poderle brindar la oportunidad de realizar su práctica profesional.'),0);
    $pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('La práctica profesional es una actividad formativa del estudiante, la cual consiste en asumir un rol profesional, a través de su inserción en una realidad o ambiente laboral específico, al mismo tiempo, se convierte en un aporte de valor de a la institución, partiendo de su capacidad, habilidad y conocimientos adquiridos, cuya meta es producir y/o potenciar algún producto dentro de la institución.'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Para continuar con los trámites relacionados con la práctica profesional le solicitamos facilitar al estudiante la siguiente información, misma que es necesaria para que él pueda completar y presentar formal solicitud:'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->cell(170,6,utf8_decode('a.	Perfil de la institución: Misión, visión, objetivos estratégicos, valores institucionales '),0,1);
	$pdf->SetX(26);
	$pdf->cell(170,6,utf8_decode('datos generales de la institución.'),0,1);
	$pdf->SetX(22);
	$pdf->cell(170,6,utf8_decode('b.	Contactos: Información general de la persona que fungirá como jefe inmediato del '),0,1,'L');
	$pdf->SetX(26);
	$pdf->multicell(170,6,utf8_decode('estudiante (nombre completo, cargo, correo electrónico, teléfono (agregar extensión), celular. '),0);
	$pdf->SetX(22);
	$pdf->cell(175,6,utf8_decode('c.	Actividades: Detalle de las actividades que realizará el estudiante de acuerdo al perfil '),0,1,'L');
	$pdf->SetX(26);
	$pdf->multicell(170,6,utf8_decode('de la carrera de Informática Administrativa, tales como: análisis y diseño de sistemas, desarrollo de aplicaciones, gestión de bases de datos, gestión de redes y comunicación de datos, soporte técnico y atención a usuarios, monitoreo de procedimientos y políticas tecnológicas, pruebas y aseguramiento de la calidad, entre otras.'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Recibida la documentación solicitada, el Comité de Práctica Profesional procederá a analizarla para determinar el cumplimiento de todos los requisitos, previo a realizar la aprobación. '),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Sin otro particular que agregar, me suscribo de usted agradeciendo su apoyo al proceso formativo del estudiante.'),0);
	$pdf->ln(16);
	$pdf->Image('../dist/img/Sello.png',55,290,25);
	$pdf->Image('../dist/img/firma.png',83,293,40);
	$pdf->SetFont('Times','BI',14);
	$pdf->cell(0,6,utf8_decode('Cristian Josué Rivera Ramírez'),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Times','I',14);
	$pdf->cell(0,6,utf8_decode('Coordinador de Comité de Vinculación Universidad - Sociedad'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');


	$pdf->Output();

	$carpeta='../Documentacion_practica/'.$row['valor'].'/';
    if(!file_exists($carpeta)){
    mkdir($carpeta,0777,true);

	$pdf = new PDF('P','mm','Legal',true);
	$pdf->AddPage();
	$pdf->SetFont('Arial','',12);
	$pdf->Image('../dist/img/fondo.png',1,146,217);
    $pdf->SetX(22);
	$pdf->cell(0,6,utf8_decode('Tegucigalpa, MDC, '.fechaCastellano($fecha).''),0,1,'L');

    $pdf->SetFont('Arial','B',12);
    $pdf->SetY(50);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode(''.$row['nivela'].' |'.' '.$row['jefe_inmediato'].' '));
    $pdf->SetY(55);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode(''.$row['cargo_jefe_inmediato'].''));
    $pdf->SetY(60);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode(''.$row['nombre_empresa'].' '));
    $pdf->SetY(65);
    $pdf->SetX(23);
    $pdf->Write(15,utf8_decode('SU OFICINA'));
	$pdf->ln(14);
    $pdf->SetFillColor(255, 255, 255);
	$pdf->SetFont('Arial','',12);
	$pdf->SetX(22);
    $pdf->multicell(175,6,utf8_decode('Aprovecho la ocasión para extenderle un cordial saludo, acompañado de mis mejores deseos para su vida personal y profesional.'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Me dirijo a usted para presentar a '.$row['nombre'].', con número de cuenta '.$row['valor'].', estudiante de la carrera de Informática Administrativa de la Facultad de Ciencias Económicas, Administrativas y Contables de la Universidad Nacional Autónoma de Honduras (UNAH), a fin de poderle brindar la oportunidad de realizar su práctica profesional.'),0);
    $pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('La práctica profesional es una actividad formativa del estudiante, la cual consiste en asumir un rol profesional, a través de su inserción en una realidad o ambiente laboral específico, al mismo tiempo, se convierte en un aporte de valor de a la institución, partiendo de su capacidad, habilidad y conocimientos adquiridos, cuya meta es producir y/o potenciar algún producto dentro de la institución.'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Para continuar con los trámites relacionados con la práctica profesional le solicitamos facilitar al estudiante la siguiente información, misma que es necesaria para que él pueda completar y presentar formal solicitud:'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->cell(170,6,utf8_decode('a.	Perfil de la institución: Misión, visión, objetivos estratégicos, valores institucionales '),0,1);
	$pdf->SetX(26);
	$pdf->cell(170,6,utf8_decode('datos generales de la institución.'),0,1);
	$pdf->SetX(22);
	$pdf->cell(170,6,utf8_decode('b.	Contactos: Información general de la persona que fungirá como jefe inmediato del '),0,1,'L');
	$pdf->SetX(26);
	$pdf->multicell(170,6,utf8_decode('estudiante (nombre completo, cargo, correo electrónico, teléfono (agregar extensión), celular. '),0);
	$pdf->SetX(22);
	$pdf->cell(175,6,utf8_decode('c.	Actividades: Detalle de las actividades que realizará el estudiante de acuerdo al perfil '),0,1,'L');
	$pdf->SetX(26);
	$pdf->multicell(170,6,utf8_decode('de la carrera de Informática Administrativa, tales como: análisis y diseño de sistemas, desarrollo de aplicaciones, gestión de bases de datos, gestión de redes y comunicación de datos, soporte técnico y atención a usuarios, monitoreo de procedimientos y políticas tecnológicas, pruebas y aseguramiento de la calidad, entre otras.'),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Recibida la documentación solicitada, el Comité de Práctica Profesional procederá a analizarla para determinar el cumplimiento de todos los requisitos, previo a realizar la aprobación. '),0);
	$pdf->ln(5);
	$pdf->SetX(22);
	$pdf->multicell(175,6,utf8_decode('Sin otro particular que agregar, me suscribo de usted agradeciendo su apoyo al proceso formativo del estudiante.'),0);
	$pdf->ln(16);
	$pdf->Image('../dist/img/Sello.png',55,290,25);
	$pdf->Image('../dist/img/firma.png',83,293,40);
	$pdf->SetFont('Times','BI',14);
	$pdf->cell(0,6,utf8_decode('Cristian Josué Rivera Ramírez'),0,1,'C');
	$pdf->ln(2);
	$pdf->SetFont('Times','I',14);
	$pdf->cell(0,6,utf8_decode('Coordinador de Comité de Vinculación Universidad - Sociedad'),0,1,'C');
	$pdf->ln(2);
	$pdf->cell(0,6,utf8_decode('Departamento de Informática'),0,1,'C');


	$pdf->Output('F','../Documentacion_practica/'.$row['valor'].'/02_CARTA_PRESENTACIÓN.pdf');
	}
?>