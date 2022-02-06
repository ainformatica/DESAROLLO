<?php

session_start();
require '../Modelos/personas_modelo.php';
require_once('../clases/funcion_bitacora.php');


$Id_objeto = 281;
$MU = new personas();

$nombres = strtoupper($_POST['nombres']);
$apellidos = strtoupper($_POST['apellidos']);
$sexo = $_POST['sexo'];
$identidad = $_POST['identidad'];
$nacionalidad = $_POST['nacionalidad'];
$estado_civil = $_POST['estado_civil'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$id_tipo_persona = $_POST['id_tipo_persona'];
$Estado = $_POST['Estado'];
$correo = $_POST['correo'];
$cuenta = $_POST['cuenta'];
$telefono = $_POST['telefono'];
$direccion = strtoupper($_POST['direccion']);
//$estud = $_POST['estud'];

if(isset($_POST['estud'])){


    $consulta = $MU->registrar_persona($nombres, $apellidos, $sexo, $identidad, $nacionalidad, $estado_civil, $fecha_nacimiento, $id_tipo_persona, $Estado, $correo, $cuenta, $telefono, $direccion);
    echo $consulta;

    if ($consulta == 1) {
        # code...
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UN NUEVO ESTUDIANTE CON CUENTA: ' . $cuenta . '');
    }

}else{

    $consulta = $MU->registrar_persona_admin($nombres, $apellidos, $sexo, $identidad, $nacionalidad, $estado_civil, $fecha_nacimiento, $id_tipo_persona, $Estado, $correo, $cuenta, $telefono, $direccion);
    echo $consulta;

    if ($consulta == 1) {
        # code...
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'UN NUEVO PERSONA CON NUMERO DE EMPLEADO: ' . $cuenta . '');
    }

}





