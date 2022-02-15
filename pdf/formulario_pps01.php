<?php 

	 session_start();

require 'fpdf/fpdf.php';
require_once ('../clases/Conexion.php');

$connection->query("SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");

$usuario=$_SESSION['id_usuario'];
 $id=("select id_persona from tbl_usuarios where id_usuario='$usuario'");
$result= mysqli_fetch_assoc($mysqli->query($id));
$id_persona=$result['id_persona'];
$sql_estudiante = ("SELECT  px.valor, concat(a.nombres,' ',a.apellidos) as nombre, c.valor Correo,g.valor as direccion
,H.valor as celular, j.valor as telefono,a.fecha_nacimiento,a.identidad
FROM tbl_personas AS a
JOIN tbl_contactos c ON a.id_persona = c.id_persona
JOIN tbl_tipo_contactos d ON c.id_tipo_contacto = d.id_tipo_contacto AND d.descripcion = 'CORREO'
JOIN tbl_contactos g ON a.id_persona = g.id_persona
JOIN tbl_tipo_contactos F ON g.id_tipo_contacto = F.id_tipo_contacto AND F.descripcion = 'DIRECCION'
JOIN tbl_contactos H ON a.id_persona = H.id_persona
JOIN tbl_tipo_contactos I ON H.id_tipo_contacto = I.id_tipo_contacto AND I.descripcion = 'TELEFONO CELULAR'
JOIN tbl_contactos j ON a.id_persona = j.id_persona
JOIN tbl_tipo_contactos k ON j.id_tipo_contacto = k.id_tipo_contacto AND k.descripcion = 'TELEFONO FIJO'
JOIN tbl_personas_extendidas as px on px.id_atributo=12 and px.id_persona=a.id_persona
WHERE a.id_persona = $id_persona
LIMIT 1");

$sql_empresa = ("SELECT ep.nombre_empresa, ep.direccion_empresa, te.descripcion AS tipoe, ti.descripcion AS trabajai, ep.puesto_en_trabajo, ep.jefe_inmediato, ep.cargo_jefe_inmediato, ep.correo_jefe_inmediato, ep.telefono_jefe_inmediato, ep.celular_jefe_inmediato, na.descripcion AS nivela, ep.perfil_empresa, ep.croquis_empresa, ep.fecha_inicio_laborar from tbl_empresas_practica ep, tbl_tipo_empresa te,tbl_trabaja_institucion ti, tbl_nivel_academico na where id_persona= $id_persona AND ep.id_tipo_empresa= te.id_tipo_empresa AND ep.id_trabaja_i=ti.id_trabaja_i AND ep.id_nivel_a=na.id_nivel_a");

$sql_practica = ("SELECT pe.id_persona, pe.fecha_inicio, pe.fecha_finaliza, jl.descripcion AS jornada, concat(pe.hora_inicio,' a ',pe.hora_final) as horariol, m.modalidad from tbl_practica_estudiantes pe, tbl_modalidad m, tbl_jornada_laboral jl where id_persona= $id_persona AND pe.id_modalidad=m.id_modalidad AND pe.id_jornada_laboral=jl.id_jornada_laboral");

function fecha ($fecha) {
    $fecha = substr($fecha, 0, 10);
    $numeroDia = date('d', strtotime($fecha));
    $mes = date('m', strtotime($fecha));
    $anio = date('Y', strtotime($fecha));
    return $numeroDia."-".$mes."-".$anio;
  }

date_default_timezone_set('America/Tegucigalpa');
        $fecha = date('Y-m-d');

function listarArchivos( $path ){
    // Abrimos la carpeta que nos pasan como parámetro
    $dir = opendir($path);
    // Leo todos los ficheros de la carpeta
    while ($elemento = readdir($dir)){
        // Tratamos los elementos . y .. que tienen todas las carpetas
        if( $elemento != "." && $elemento != ".."){
            // Si es una carpeta
            if( is_dir($path.$elemento) ){
                // Muestro la carpeta
                echo "<p><strong>CARPETA: ". $elemento ."</strong></p>";
            // Si es un fichero
            } else {
                // Muestro el fichero
               return $imagen=   $path."/". $elemento;
            }
        }
    }
}

class PDF extends FPDF
{
    // Cabecera de página
	function Header()
    {
		// Logo
        $this->Image('../dist/img/logo.png',30,12,28);
        // Arial bold 15
        $this->SetFont('Arial','I',8);
        $this->SetFillColor(255, 255, 255);;
        // Movernos a la derecha
        $this->Rect(0,0,220,50,'F');
        $this->Image('../dist/img/encabezado_pps.png',10,12,195);
        // Título
		$this->SetY(20);
        $this->SetX(166);
        $this->Write(15,utf8_decode('30/09/2021'));
        $this->SetY(32);
        $this->SetX(186);
        $this->SetFont('Arial','I',8);
        $this->SetY(27);
        $this->SetX(185);
        $this->Write(15,utf8_decode('1.0'));
        $this->SetY(35);
        $this->SetX(173);
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().' de {nb}',0,0,'C');

        $this->Ln(20);
    }
} 
//date_default_timezone_get('America/Tegucigalpa');


	$resultado = mysqli_query($connection, $sql_estudiante);
	$row = mysqli_fetch_array($resultado);

	$resultado = mysqli_query($connection, $sql_empresa);
	$row2 = mysqli_fetch_array($resultado);

	$resultado = mysqli_query($connection, $sql_practica);
	$row1 = mysqli_fetch_array($resultado);
                 

	$pdf = new PDF();
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','B',15);
    $pdf->Image('../dist/img/parte_01.png',1,45,217);
	$pdf->SetFont('Arial','',10);
	$pdf->ln(2);
	$pdf->SetY(66.5);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode($row['nombre']),0);
	$pdf->SetY(75);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row['valor'].''),0);
	$pdf->SetY(75);
	$pdf->SetX(110);
	$pdf->cell(170,5,utf8_decode(''.$row['identidad'].''),0);
	$pdf->SetY(85);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.fecha($row['fecha_nacimiento']).''),0);
	$pdf->SetY(95);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row['direccion'].''),0);
	$pdf->SetY(104);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row['telefono'].''),0);
	$pdf->SetY(104);
	$pdf->SetX(115);
	$pdf->cell(170,5,utf8_decode(''.$row['celular'].''),0);
	$pdf->SetY(114);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row['Correo'].''),0);
	$pdf->SetY(140);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row1['modalidad'].''),0);
	$pdf->SetY(159);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row1['jornada'].''),0);
	$pdf->SetY(135);
	$pdf->SetX(126);
	$pdf->cell(170,5,utf8_decode(''.fecha($row1['fecha_inicio'].'')),0);
	$pdf->SetY(146);
	$pdf->SetX(126);
	$pdf->cell(170,5,utf8_decode(''.fecha($row1['fecha_finaliza'].'')),0);
	$pdf->SetY(159);
	$pdf->SetX(153);
	$pdf->cell(170,5,utf8_decode(''.$row1['horariol'].''),0);
	$pdf->SetY(172);
	$pdf->SetX(67);
	$pdf->cell(170,5,utf8_decode(''.$row2['trabajai'].''),0);
	$pdf->SetY(114);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row2['puesto_en_trabajo'].''),0);
	$pdf->SetY(182);
	$pdf->SetX(77);
	$pdf->cell(170,5,utf8_decode(''.fecha($row2['fecha_inicio_laborar'].'')),0);
	$pdf->SetY(200);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row2['nombre_empresa'].''),0);
	$pdf->SetY(209);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode(''.$row2['direccion_empresa'].''),0);
	$pdf->SetY(217);
	$pdf->SetX(53);
	$pdf->cell(170,5,utf8_decode($row2['tipoe']),0);
	$pdf->SetY(231);
	$pdf->SetX(17);
	$pdf->multicell(190,5,utf8_decode($row2['perfil_empresa']),0);
	
	$direccion="../archivos/PPS01_CROQUIS/".$row['valor'];
	
	for($i = 0; $i < 2; $i++){
		if($i == 0){
			$pdf->AddPage();
			$pdf->Image('../dist/img/parte_02.png',1,44,217);
			$pdf->ln(2);
			$pdf->SetY(102);
			$pdf->SetX(53);
			//$pdf->cell(170,5,utf8_decode(''.$row2['croquis_empresa'].''),0);
			$pdf->Image(listarArchivos($direccion),20,55, 181, 45);
			$pdf->SetY(113);
			$pdf->SetX(53);
			$pdf->cell(170,5,utf8_decode(''.$row2['jefe_inmediato'].''),0);
			$pdf->SetY(112);
			$pdf->SetX(135);
			$pdf->cell(170,5,utf8_decode(''.$row2['cargo_jefe_inmediato'].''),0);
			$pdf->SetY(121);
			$pdf->SetX(53);
			$pdf->cell(170,5,utf8_decode(''.$row2['correo_jefe_inmediato'].''),0);
			$pdf->SetY(121);
			$pdf->SetX(135);
			$pdf->cell(170,5,utf8_decode(''.$row2['telefono_jefe_inmediato'].''),0);
			$pdf->SetY(121);
			$pdf->SetX(180);
			$pdf->cell(170,5,utf8_decode(''.$row2['celular_jefe_inmediato'].''),0);
			$pdf->SetY(129);
			$pdf->SetX(53);
			$pdf->cell(170,5,utf8_decode(''.$row2['nivela'].''),0);
		}else{
			$pdf->AddPage();
			$pdf->Image('../dist/img/parte_03.png',1,45,217);
		}
	}

	$pdf->Output();

?>