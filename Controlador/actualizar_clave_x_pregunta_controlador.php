<?php

require_once('../clases/Conexion.php');
require_once('../clases/encriptar_desencriptar.php');
require_once('../clases/funcion_contra.php');
//require_once('../vistas/pagina_inicio_cambiar_clave_pregunta.php');

$Nueva_clave = cifrado::encryption($_POST['txt_nuevaclave']);
$Confirmar_clave = cifrado::encryption($_POST['txt_confirmarclave']);
$Id_usuarios2 = $_GET['id_usuario'];
$msj = 0;


if ($_POST) {
	$error_encontrado = "";
	if (validar_contra::validar_clave($_POST['txt_nuevaclave'], $error_encontrado)) {


		if ($Nueva_clave == $Confirmar_clave) {
			$sql = "call proc_actualizar_clave_x_pregunta('$Nueva_clave','$Id_usuarios2')";
			$resultado = $mysqli->query($sql);

			if ($resultado == true) {
				$msj = 3;
			} else {
				$msj = 4;
			}
		} else {
			$msj = 1;
		}
	} else {
		$msj = 2;
	}
}
if (isset($resultado)) {
	header("location: ../login.php");
}else{
	if ($msj == 2) {
		header("location: ../vistas/cambiar_clave_x_pregunta_vista.php?msj=$msj&error= " . $error_encontrado . "&id_usuario2=$Id_usuarios2");
	} else {
		header("location: ../vistas/cambiar_clave_x_pregunta_vista.php?msj=$msj&id_usuario2=$Id_usuarios2");
	}
}


?>
