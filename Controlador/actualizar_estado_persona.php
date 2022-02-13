<?php
ob_start();
session_start();
require '../Modelos/plan_estudio_modelo.php';

$MU = new modelo_plan();
$id_persona = $_POST["id_persona"];
$estado = $_POST["Estado"];

$consulta = $MU->estado($estado, $id_persona);
echo $consulta;
?>