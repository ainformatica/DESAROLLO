<?php
    require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 96;
    $MU = new modelo_plan();

$nombre = $_POST['nombre'];
$num_clases = $_POST['num_clases'];
$fecha_creacion = $_POST['fecha_creacion'];
$codigo_plan = $_POST['codigo_plan'];
$plan_vigente = $_POST['plan_vigente'];
$id_tipo_plan = $_POST['id_tipo_plan'];
$creado_por =$_POST['Creado_por'];
$numero_acta = $_POST['numero_acta'];
$fecha_acta = $_POST['fecha_acta'];
$fecha_emision = $_POST['fecha_emision'];
$creditos= $_POST['creditos_plan'];
$activo = $_POST['activo'];

    $consulta = $MU->crear_plan_estudio($nombre, $num_clases, $fecha_creacion, $codigo_plan, $plan_vigente, $id_tipo_plan,$creado_por, $numero_acta, $fecha_acta, $fecha_emision,$creditos,$activo);
    echo $consulta;

if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UNA NUEVO PLAN DE ESTUDIO' . $nombre.'');
}
