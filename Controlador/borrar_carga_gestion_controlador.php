<?php
ob_start();
session_start();

require '../Modelos/tabla_carga_modelo.php';
require_once('../clases/funcion_bitacora.php');
$Id_objeto = 47;

$MU = new modeloCarga();

$id_carga = $_POST['id_carga_academica'];


$consulta = $MU->eliminar_carga($id_carga);

echo $consulta;

if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ELIMINO', 'UNA CARGA ACADÉMICA REGISTRO #' . $id_carga.'');
}

 ?>