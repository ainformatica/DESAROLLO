<?php
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/conexion_mantenimientos.php');
$Id_objeto = 16017;


$visualizacion = permiso_ver($Id_objeto);

$nombre = $_SESSION['usuario'];
$id_usuario = $_SESSION['id_usuario'];
if ($visualizacion == 0) {
echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos no tiene permiso de visualizar la pantalla",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
    window.location = "../vistas/pagina_principal_vista.php";
</script>';
} else {

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A GESTIÓN DE PERSONAS.');


// if (permisos::permiso_insertar($Id_objeto) == '1') {
// $_SESSION['btn_guardar_cambio_plan'] = "";
// } else {
// $_SESSION['btn_guardar_cambio_plan'] = "disabled";
// }
}
ob_end_flush();

?>