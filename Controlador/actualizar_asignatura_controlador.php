<?php

ob_start();
session_start();
require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 108;
$MU = new modelo_plan();

$id_area = $_POST["id_area"];
$uv = $_POST["uv"];
$codigo = strtoupper($_POST["codigo"]);
$asignatura = $_POST["asignatura"];
$reposicion = $_POST["reposicion"];
$suficiencia = $_POST["suficiencia"];
$id_asignatura = $_POST["Id_asignatura"];
$id_plan_estudio = $_POST["id_plan_estudio"];
$id_periodo_plan = $_POST["id_periodo_plan"];
$carga = $_POST["carga"];

$consulta = $MU->ActualizarAsignatura($id_area, $uv, $codigo, $asignatura, $reposicion, $suficiencia, $id_asignatura,$id_periodo_plan,$carga,$id_plan_estudio);
echo $consulta;

if ($consulta == 1) {
# code...
bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'UNA ASIGNATURA DE SERVICIO: ' . $asignatura . ' CON REGISTRO # '. $id_asignatura.'');
}
?>