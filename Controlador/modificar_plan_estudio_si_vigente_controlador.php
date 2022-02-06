<?php
require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 98;
$MU = new modelo_plan();

$vigencia_no = $_POST['vigencia_no'];

$estado_inactivo_asig = $_POST['estado_inactivo_asig'];
$id_plan = $_POST['id_plan'];
$modificado_por = $_POST['modificado_por'];
$fecha_ultima_vigencia = $_POST['fecha_ultima_vigencia'];
$nombre = $_POST['nombre'];

$consulta = $MU->modificar_plan_estudio_si($vigencia_no, $modificado_por, $fecha_ultima_vigencia, $estado_inactivo_asig, $id_plan);
echo $consulta;

if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA VIGENCIA DE UN PLAN DE ESTUDIO DE NOMBRE: ' . $nombre . ' VIGENCIA NUEVA: ' . $vigencia_no. '');
}
