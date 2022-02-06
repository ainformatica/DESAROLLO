<?php
ob_start();
session_start();
require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 110;
$MU = new modelo_plan();



$uv = $_POST["uv"];
$codigo = strtoupper($_POST["codigo"]);
$asignatura = $_POST["asignatura"];
$reposicion = $_POST["reposicion"];
$suficiencia = $_POST["suficiencia"];
$id_asignatura = $_POST["Id_asignatura"];

$consulta = $MU->ActualizarAsignaturaServicio($uv, $codigo, $asignatura, $reposicion, $suficiencia, $id_asignatura);
echo $consulta;

if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'UNA ASIGNATURA DE SERVICIO: ' . $asignatura . ' CON REGISTRO # '. $id_asignatura.'');
}
