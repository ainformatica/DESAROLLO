<?php

session_start();
require '../Modelos/reporte_carga_modelo.php';
require_once('../clases/funcion_bitacora.php');
require_once('../clases/encriptar_desencriptar.php');


$Id_objeto = 3;
$MU = new modelo_modal();

$id_persona = $_POST['id_persona'];
$Id_rol = $_POST['Id_rol'];
$Usuario = strtoupper($_POST['Usuario']);
//$Contrasena = $_POST['Contrasena'];
$Fec_vence_contrasena = $_POST['Fec_vence_contrasena'];
$Intentos = $_POST['Intentos'];
$estado = $_POST['estado'];
$Fecha_creacion = $_POST['Fecha_creacion'];
$Creado_por = $_POST['Creado_por'];
$Clave = cifrado::encryption($_POST['Contrasena']);


$consulta = $MU->registrar_usuario($id_persona, $Id_rol, $Usuario, $Fec_vence_contrasena, $Intentos, $estado, $Fecha_creacion, $Creado_por, $Clave);
echo $consulta;

if ($consulta == 1) {
    # code...
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UN NUEVO USUARIO CON NOMBRE: ' . $Usuario . '');
}
