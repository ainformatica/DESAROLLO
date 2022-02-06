<?php
require '../Modelos/plan_estudio_modelo.php';
// require_once('../clases/funcion_bitacora.php');
// $Id_objeto = 98;
    $MU = new modelo_plan();

$Id_asignatura = $_POST['Id_asignatura'];
$id_equivalencias = $_POST['id_equivalencias'];


$consulta = $MU->insAsigEqui($Id_asignatura, $id_equivalencias);
echo $consulta;

    // if ($consulta==1) {
    // # code...
    //      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'UN PLAN DE ESTUDIO' .$nombre.'');
     
    // }
