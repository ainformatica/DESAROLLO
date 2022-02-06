<?php
ob_start();
session_start();
require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 109;
$MU = new modelo_plan();



$uv = $_POST["uv"];
$codigo = strtoupper($_POST["codigo"]);
$asignatura = $_POST["asignatura"];
$reposicion = $_POST["reposicion"];
$suficiencia = $_POST["suficiencia"];
$id_tipo_asignatura = $_POST["id_tipo_asignatura"];
$estado = $_POST["estado"];

$consulta = $MU->registrarAsignaturaServicio($uv, $codigo, $estado, $asignatura, $reposicion, $suficiencia, $id_tipo_asignatura);
echo $consulta;

if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UNA NUEVA ASIGNATURA DE SERVICIO: ' . $asignatura .'');
}
