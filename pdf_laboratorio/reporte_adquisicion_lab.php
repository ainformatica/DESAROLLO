<?php

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
// $pdf->Cell(100,8,utf8_decode('REPORTE DE ADQUISICIÓN'),1,0,'C'); 
// $pdf->Ln(20);
//$pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra




// $pdf->Cell(40,10,utf8_decode('Fecha de reporte'),1,0,'C'); 

//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','',10);
$pdf->Cell(1,6,'',0,0,'C');//mk
 

// $pdf->Ln(7);


//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../Modelos/gestion_lab_modelo.php";
$reportes = new reportes();

if (isset($_GET['id_adquisicion'])) {
    $id_adquisicion1 = $_GET['id_adquisicion'];
}


// $id_adquisicion1=$_GET['id_adquisicion'];
$id_adquisicion=intval($id_adquisicion1);
$rspta0 = $reportes->reportes_adquisicion_tipo($id_adquisicion);
$acum=0;
while($reg= $rspta0->fetch_object())
{  
    $id=$reg->id;
    $pdf->Cell(80,8,utf8_decode('FICHA DE ADQUISICIÓN NO. '.$reg->id),1,0,'C'); 
    $pdf->Ln(5);
    $pdf->Ln(5);

    // $reportes_inv = $reg->numero_inventario;
    $tipo = $reg->tipo;
    $descripcion = $reg->descripcion;
    $fecha = $reg->fecha;
    $estado = $reg->estado;
    // $reportes_caracteristicas = strtolower($reg->caracteristicas);
    // $caracteristicas = $reg->ubicacion;
    // $ubicacion = $reg->caracteristicas;
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(20,6,'',0,0,'C');
  
   
    // $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(25,8,'',0,0,'C');
	$pdf->Cell(20,7 ,utf8_decode(('TIPO DE ADQUISICIÓN: '.$tipo)),0,0,'L'); 
	$pdf->Ln(6);
    $pdf->Cell(45,8,'',0,0,'C');
    $pdf->Cell(20,9,utf8_decode(('DESCRIPCIÓN: '.$descripcion)),0,0,'L'); 
	$pdf->Ln(6);
    $pdf->Cell(45,8,'',0,0,'C');
    $pdf->Cell(20,10,utf8_decode('FECHA DE ADQUISICIÓN: '.$fecha),0,0,'L'); 
    $pdf->Ln(6);
    $pdf->Cell(45,8,'',0,0,'C');
    $pdf->Cell(20,10,utf8_decode('ESTADO: '.$estado),0,0,'L'); 
    // $pdf->Ln(7);
    // $pdf->Cell(30,6,'',0,0,'C');
    // $pdf->Cell(30,6,utf8_decode(utf8_decode($reportes_descripcion)),0,0,'L'); 
    // $pdf->Ln(7);
    // $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Ln(15);
    // $pdf->Cell(20,6,'',0,0,'C');
    // $pdf->Cell(30,4,utf8_decode('Caracteristicas: '.utf8_decode($reportes_caracteristicas)),0,0,'L'); 

}

$rspta = $reportes->reportes_adquisicion($id_adquisicion);

//Implementamos las celdas de la tabla con los registros a mostrar

$pdf->SetWidths(array(26,26,25,70));

//57,46,45



// $acum=0;
while($reg= $rspta->fetch_object())
{  
  $acum=$acum+1;
    // $reportes_inv = $reg->numero_inventario;
    $reportes_nombre = $reg->nombre_producto;
    $reportes_descripcion = $reg->numero_inventario;
    $id_detalle=$reg->id_detalle;
    // $reportes_caracteristicas = strtolower($reg->caracteristicas);
    // $caracteristicas = $reg->ubicacion;
    // $ubicacion = $reg->caracteristicas;
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(20,6,'',0,0,'C');
  
    $pdf->Cell(30,6,utf8_decode('DETALLE NO.'.$acum),1,1,'C'); 
    
    // $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Ln(3);
    
    
    $pdf->Cell(20,6,'',0,0,'C');

    // $pdf->Row(array(utf8_decode($reportes_inv),utf8_decode($reportes_nombre),utf8_decode($caracteristicas),utf8_decode($ubicacion)));
    $pdf->Cell(30,6,utf8_decode('NO. INVENTARIO: '.utf8_decode($reportes_descripcion)),0,0,'L'); 
    $pdf->Ln(7);
    $pdf->Cell(20,6,'',0,0,'C');

    $pdf->Cell(30,6,utf8_decode('PRODUCTO: '.utf8_decode($reportes_nombre)),0,0,'L'); 
    $pdf->Ln(7);
    // $pdf->Cell(55,6,'',0,0,'C');
   
    // $pdf->Ln(3);
    $rspta1 = $reportes->reportes_adquisicion_caracteristicas($id_detalle);
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(30,6,utf8_decode('CARACTERÍSTICAS: '),0,0,'C'); 
    $pdf->Ln(7);
    while($reg= $rspta1->fetch_object())
{  
    
    // $reportes_inv = $reg->numero_inventario;
    $reportes_caracteristica = $reg->caracteristica;
    $reportes_valor = $reg->valor;
    // $reportes_caracteristicas = strtolower($reg->caracteristicas);
    // $caracteristicas = $reg->ubicacion;
    // $ubicacion = $reg->caracteristicas;
    $pdf->SetFont('Arial','',8);
    // $pdf->Cell(20,6,'',0,0,'C');
  
   
    // $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Cell(20,6,'',0,0,'C');

    // $pdf->Row(array(utf8_decode($reportes_caracteristica),utf8_decode($reportes_valor)));
	$pdf->Cell(30,6,utf8_decode(utf8_decode($reportes_caracteristica.': '.$reportes_valor)),0,0,'L'); 
    // $pdf->Ln(7);
    // $pdf->Cell(30,6,'',0,0,'C');
    // $pdf->Cell(30,6,utf8_decode(utf8_decode($reportes_descripcion)),0,0,'L'); 
    // $pdf->Ln(7);
    $pdf->Cell(20,6,'',0,0,'C');
    $pdf->Ln(7);
    // $pdf->Cell(20,6,'',0,0,'C');
    // $pdf->Cell(30,4,utf8_decode('Caracteristicas: '.utf8_decode($reportes_caracteristicas)),0,0,'L'); 

}
    $pdf->Ln(5);
    // $pdf->Cell(20,6,'',0,0,'C');
    // $pdf->Cell(30,4,utf8_decode('Caracteristicas: '.utf8_decode($reportes_caracteristicas)),0,0,'L'); 

}


//Mostramos el documento pdf
ob_start();

session_start();




//Mostramos el documento pdf
$pdf->Output();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
// require_once('../clases/funcion_visualizar.php');
// require_once('../clases/funcion_permisos.php');


$Id_objeto = 210;
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Reporte', 'Genero un reporte de la ficha de adquisicion no. '.$id);



?>