<?php
ob_start();
session_start();

require '../Modelos/reporte_carga_modelo.php';


$MU = new modelo_modal();

$id_periodo = $_POST['id_periodo'];



$consulta = $MU->eliminarcargaPeriodo($id_periodo);

echo $consulta;

