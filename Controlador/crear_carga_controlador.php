
<?php
ob_start();
session_start();

require ('../Modelos/tabla_carga_modelo.php');
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 47;
$MU = new modeloCarga();

$control = $_POST['control'];
$seccion = $_POST['seccion'];
$num_alumnos = $_POST['num_alumnos'];
$id_persona = $_POST['id_persona'];
$id_aula = $_POST['id_aula'];
$id_asignatura = $_POST['id_asignatura'];
$dias = $_POST['dias'];
$id_modalidad = $_POST['id_modalidad'];
$hora_inicial = $_POST['hora_inicial'];
$hora_final = $_POST['hora_final'];
$id_modalidad = $_POST['id_modalidad'];

$consulta = $MU->crear_carga_academica($control, $seccion, $num_alumnos, $id_persona, $id_aula, $id_asignatura, $dias, $id_modalidad, $hora_inicial, $hora_final);
echo $consulta;

if ($consulta === 1) {
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESÓ', 'UNA NUEVA CARGA ACADÉMICA');


}



?>
