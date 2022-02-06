<?php
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora_movil.php');


$Id_objeto = 175;
$opcion = $_GET['op'];


if (isset($_POST['funcion'])) {
  if ($_POST['funcion']=='eliminar') {
      $id = (int)$_POST['id'];
              //se ejecuta el sql respectivo
              $sql = "DELETE FROM tbl_movil_tipo_notificaciones where id = $id";
              $resultado = $mysqli->query($sql);
              if ($resultado) {
                  echo 'hola mundo';
              }else{
                  echo '';
              }
  }
}

if ($opcion == 'editar') {
  $id_tiponotificacion = isset($_GET["id"]) ? ($_GET["id"]) : "";
  $tipo_notificacion = isset($_POST['tipo_notificacion']) ? strtoupper($_POST['tipo_notificacion']) : '';
  $descripcion = isset($_POST["descripcion"]) ? strtoupper($_POST["descripcion"]) : "";
  $sql="UPDATE tbl_movil_tipo_notificaciones set tipo_notificacion = '$tipo_notificacion', descripcion= '$descripcion' WHERE id = $id_tiponotificacion";
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'MODIFICO',"$sql");
  $mysqli->query($sql);
  header('location: ../vistas/movil_mantenimiento_tipo_notificacion_vista.php?msj=2');

}else{
  $tipo_notificacion = isset($_POST['tipo_notificacion']) ? strtoupper($_POST['tipo_notificacion']) : '';
  $descripcion = isset($_POST["descripcion"]) ? strtoupper($_POST["descripcion"]) : "";
//Logica para el que se repite
$sqlexiste = ("select count(tipo_notificacion) as notificacion from tbl_movil_tipo_notificaciones where tipo_notificacion='$tipo_notificacion'");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

/* Logica para que no acepte campos vacios */
/*if ($_POST['descripcion' ) {*/
if (!empty($_POST['tipo_notificacion'])) { /* Condicion para que no se repita el rol*/
  if ($existe['notificacion'] == 1) {
    //redireccion ya que el nombre segmento existe
 	header('location: ../vistas/movil_mantenimiento_tipo_notificacion_vista.php?msj=1'); 
  } else {
    /* Query para que haga el insert*/
    $sql = "INSERT into tbl_movil_tipo_notificaciones VALUES (null,'$tipo_notificacion','$descripcion')";
    $resultado = $mysqli->query($sql);
    if ($resultado) {
      bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INSERTO', "$sql");
      header('location: ../vistas/movil_mantenimiento_tipo_notificacion_vista.php?msj=2');
    } else {
      echo "Error: " . $sql;
    }
  }
} else {
  header('location: ../vistas/movil_mantenimiento_tipo_notificacion_vista.php?msj=3');
}

}
ob_end_flush();