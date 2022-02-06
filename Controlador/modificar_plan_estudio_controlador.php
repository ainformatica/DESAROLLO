<?php
require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 98;
    $MU = new modelo_plan();

$nombre = $_POST['nombre'];
$num_clases = $_POST['num_clases'];
$codigo_plan = $_POST['codigo_plan'];
$id_tipo_plan = $_POST['id_tipo_plan'];
$fecha_modificacion = $_POST['fecha_modificacion'];
$modificado_por = $_POST['modificado_por'];
$id_plan_estudio = $_POST['id_plan_estudio'];
$creditos_plan = $_POST['creditos_plan'];



    $consulta = $MU->modificar_plan_estudio($nombre, $num_clases, $codigo_plan, $id_tipo_plan, $fecha_modificacion, $modificado_por, $creditos_plan,$id_plan_estudio);
    echo $consulta;

    if ($consulta==1) {
    # code...
         bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'UN PLAN DE ESTUDIO' .$nombre.'');
     
    }
