<?php
ob_start();
session_start();
require '../Modelos/tabla_carga_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 47;

$MU = new modeloCarga();

$id_carga_academica = $_POST['id_carga_academica'];
$id_asignatura = $_POST['id_asignatura'];
$seccion = $_POST['seccion'];
$hra_inicio = $_POST['hora_inicial'];
$hra_final = $_POST['hora_final'];
$dias = $_POST['dias'];
//$id_aula = $_POST['id_aula'];
$num_alumnos = $_POST['num_alumnos'];
$control = $_POST['control'];
$id_modalidad = $_POST['id_modalidad'];

    $consulta = $MU->modificar_carga_academica_virtual($control, $seccion, $hra_inicio, $hra_final, $num_alumnos, $id_asignatura, $dias, $id_modalidad, $id_carga_academica);
    echo $consulta;

    if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'UNA CARGA ACADÉMICA REGISTRO #' .$id_carga_academica . ' SECCION: ' . $seccion . '');
}
?>