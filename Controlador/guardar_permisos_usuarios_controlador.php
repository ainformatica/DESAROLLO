<?php

session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto = 8;

$checkInsertar = 0;
$checkModificar = 0;
$checkEliminar = 0;
$checkVer = 0;

$Comborol = $_POST['comborol'];
$array_id = $_POST['objeto'];
$operacion= $_POST['operacion'];

//Si todo está correcto, procedemos a generar la consulta

//Obtenemos cada clave y su valor para poder contar la cantidad de datos e ingresarlos acorde a cada clave



if (isset($_POST['checkbox_insertar']) && $_POST['checkbox_insertar'] == 'true') {
	$checkInsertar = 1;
} else {
	$checkInsertar = 0;
}
if (isset($_POST['checkbox_modificar']) && $_POST['checkbox_modificar'] == 'true') {
	$checkModificar = 1;
} else {
	$checkModificar = 0;
}
if (isset($_POST['checkbox_eliminar']) && $_POST['checkbox_eliminar'] == 'true') {
	$checkEliminar = 1;
} else {
	$checkEliminar = 0;
}
if (isset($_POST['checkbox_visualizar']) && $_POST['checkbox_visualizar'] == 'true') {
	$checkVer = 1;
} else {
	$checkVer = 0;
}



if ($Comborol > 0) {
    if($operacion==2){//Eliminar los registros para reemplazarlos por nuevos.
        $sqleliminar_permisos="delete from tbl_permisos_usuarios where Id_rol='$Comborol';";
        $resultado_eliminar = $mysqli->query($sqleliminar_permisos);

    }


	foreach ($array_id as $identificador) {
		$sqlexiste = ("select count(Id_permisos_usuario) as permiso  from tbl_permisos_usuarios where Id_rol='$Comborol' and Id_objeto='$identificador'");
		//Obtener la fila del query
		$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
		if ($existe['permiso'] >= 1) {
			echo '<script type="text/javascript">
                    swal({
                       title:"",
                       text:"Lo sentimos hay algunos permisos ya existente y no seran guardados",
                       type: "error",
                       showConfirmButton: false,
                       timer: 3000
                    });
                </script>';
		} else {

			
			$sql = "call pro_insertar_permisos ('$Comborol', '$identificador' , '$checkInsertar' , '$checkModificar' , '$checkEliminar' , '$checkVer',' " . $_SESSION['usuario'] . " ')";

			$resultado = $mysqli->query($sql);
			$sqlnombre = "select objeto as objeto from tbl_objetos where Id_objeto ='$identificador'";

			$resultadonombre = mysqli_fetch_assoc($mysqli->query($sqlnombre));
			bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INSERTO', 'EL PERMISO ' . $resultadonombre['objeto'] . '');
		}
	};
	if ($resultado === TRUE) {
		/*header('location: ../contenidos/permisosroles-view.php?msj=1');*/

		echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos  se almacenaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 1500
                                });
                               window.location.href="../vistas/crear_permisos_usuarios_vista.php";
                            </script>';
	} else {
		echo "Error: " . $sql;
	}
} else {
	header('location: ../vistas/crear_permisos_usuarios_vista.php?msj=2');
	echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"Lo sentimos tiene campos por rellenar",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 1500
                                    });
                                </script>';
}

?>