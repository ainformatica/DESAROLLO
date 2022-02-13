<?php
ob_start();
session_start();
require '../Modelos/plan_estudio_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 16017;
$MU = new modelo_plan();
$id_persona = $_POST["id_persona"];
$estado = $_POST["Estado"];

$nombres = $_POST["nombres"];

$consulta = $MU->estado($estado, $id_persona);
echo $consulta;



if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'EL ESTADO DE UNA PERSONA: ' . $nombres . 'ESTADO: ' . $estado . '');
}

?>