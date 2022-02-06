<?php

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_TableGESTIONLAB.php');
$fecha = new DateTime(null, new DateTimeZone('America/Tegucigalpa'));
$hora = $fecha->format("H:i:s");

//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();

//Agregamos la primera página al documento pdf
$pdf->AddPage();

//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
$pdf->Ln(10);

//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
//ENCABEZADO QUE DEBE IR IGUAL EN TODOS LOSREPORTES

$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,6,'',0,0,'C');
$pdf->Cell(78,9,utf8_decode('UNIVERSIDAD NACIONAL AUTÓNOMA DE HONDURAS'),0,0,'C'); 
$pdf->Ln(5);
$pdf->Cell(60,6,'',0,0,'C');
$pdf->Cell(80,9,utf8_decode('FACULTAD DE CIENCIAS ECONÓMICAS, ADMINISTRATIVAS Y CONTABLES'),0,0,'C'); 
$pdf->Ln(5);
$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(120,9,utf8_decode('DEPARTAMENTO DE INFORMÁTICA'),0,0,'C'); 
// $pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 
$pdf->Ln(5);
$pdf->SetFont('Arial','',10);
$pdf->Cell(1,6,'',0,0,'C');
$pdf->Ln(10);
$pdf->Cell(40,5,date('d/m/Y').' '.$hora,0,0,'C');
$pdf->Ln(10);
$pdf->Cell(45,6,'',0,0,'C');






$pdf->Cell(100,8,utf8_decode('REPORTE DE ASIGNACIÓN INDIVIDUAL'),1,0,'C'); 
$pdf->Ln(10);
//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra




// $pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(1,6,'',0,0,'C');//mk
 

$pdf->Ln(7);

//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/gestion_lab_modelo.php";
$reportes = new reportes();

$id_asignacion=$_GET['id_asignacion'];
// $nombre_producto=intval($nombre_producto1);

 
$rspta = $reportes->reportes_asignacion($id_asignacion);

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(26,26,25,70));

//57,46,45
while($reg= $rspta->fetch_object())
{  
    
    // $reportes_inv = $reg->numero_inventario;
    $reportes_inventario = $reg->inventario;
    $reportes_producto =$reg->producto;
    $reportes_ubicacion =$reg->ubicacion;
    $reportes_nombre =$reg->nombre;
    $reportes_ubicacion_previa =$reg->ubicacion_previa;
    $reportes_nombre_previo =$reg->nombre_previo;
    $reportes_motivo =$reg->motivo;
    $reportes_motivo_previo =$reg->motivo_previo;
    $reportes_fecha_previo =$reg->fecha_previa;
    $reportes_fecha =$reg->fecha;
    // $caracteristicas = $reg->ubicacion;
    // $ubicacion = $reg->caracteristicas;
    $pdf->SetFont('Arial','',10);

    $pdf->Cell(30,6,'',0,0,'C');
	$pdf->Cell(30,6,utf8_decode('No. INVENTARIO: '.utf8_decode($reportes_inventario)),0,0,'L'); 
    $pdf->Ln(7);

    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,6,utf8_decode('PRODUCTO: '.utf8_decode($reportes_producto)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('UBICACIÓN PREVIA: '.utf8_decode($reportes_ubicacion_previa)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('UBICACIÓN ACTUAL: '.utf8_decode($reportes_ubicacion)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('RESPONSABLE PREVIO: '.utf8_decode($reportes_nombre_previo)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('RESPONSABLE ACTUAL: '.utf8_decode($reportes_nombre)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('MOTIVO PREVIO: '.utf8_decode($reportes_motivo_previo)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('MOTIVO ACTUAL: '.utf8_decode($reportes_motivo)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('FECHA PREVIA: '.utf8_decode($reportes_fecha_previo)),0,0,'L'); 

    $pdf->Ln(7);
    $pdf->Cell(30,6,'',0,0,'C');
    $pdf->Cell(30,4,utf8_decode('FECHA ACTUAL: '.utf8_decode($reportes_fecha)),0,0,'L'); 





   

}
ob_start();

session_start();




//Mostramos el documento pdf
$pdf->Output();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
// require_once('../clases/funcion_visualizar.php');
// require_once('../clases/funcion_permisos.php');


$Id_objeto = 214;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Reporte', 'Genero un reporte de los datos de la asignacion del producto  '.$reportes_producto);

?>

