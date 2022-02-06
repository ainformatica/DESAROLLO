<?php
ob_start();
session_start();
require "../Modelos/perfil_docente_modelo.php";
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 54;
$MU = new modelo_perfil_docentes();



$nombre = isset($_POST["Nombre"]) ? limpiarCadena1($_POST["Nombre"]) : "";
$apellido = isset($_POST["apellido"]) ? limpiarCadena1($_POST["apellido"]) : "";
$id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";
$nacionalidad = isset($_POST["nacionalidad"]) ? limpiarCadena1($_POST["nacionalidad"]) : "";
$estado = isset($_POST["estado_civil"]) ? limpiarCadena1($_POST["estado_civil"]) : "";
$sexo = isset($_POST["sexo"]) ? limpiarCadena1($_POST["sexo"]) : "";

$identidad = isset($_POST["identidad"]) ? limpiarCadena1($_POST["identidad"]) : "";
$fecha_nacimiento = isset($_POST["fecha_nacimiento"]) ? limpiarCadena1($_POST["fecha_nacimiento"]) : "";


$consulta = $MU->Actualizar($nombre, $apellido, $identidad, $nacionalidad, $estado, $sexo, $fecha_nacimiento, $id_persona);
echo $consulta;


if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'SUS PERFIL DE USUARIO: ' . $nombre . '');
}
