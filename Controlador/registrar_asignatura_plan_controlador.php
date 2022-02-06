<?php
ob_start();
session_start();
require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 107;
$MU = new modelo_plan();

$id_plan_estudio = $_POST["id_plan_estudio"] ;
$id_periodo_plan = $_POST["id_periodo_plan"];
$id_area = $_POST["id_area"];
$uv = $_POST["uv"];
$codigo = strtoupper($_POST["codigo"]);
$asignatura = $_POST["asignatura"];
$reposicion = $_POST["reposicion"];
$suficiencia = $_POST["suficiencia"];
$id_tipo_asignatura = $_POST["id_tipo_asignatura"];
$estado = $_POST["estado"];
$carga = $_POST["carga"];

$consulta = $MU->registrarAsignatura($id_plan_estudio, $id_periodo_plan, $id_area, $uv, $codigo, $estado, $asignatura, $reposicion, $suficiencia, $carga,$id_tipo_asignatura);
echo $consulta;

if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UNA NUEVA ASIGNATURA: ' . $asignatura . ' AL PLAN CON REGISTRO #: ' . $id_plan_estudio.'');
}
