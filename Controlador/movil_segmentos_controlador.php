<?php
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora_movil.php');

$Id_objeto = 171;
$opcion = isset($_GET['op']) ? $_GET['op'] : '';

if ($opcion == 'editar') {
  $id_segmento = isset($_GET["id"]) ? ($_GET["id"]) : "";
  $nombre = isset($_POST["nombre"]) ? strtoupper($_POST["nombre"]) : "";
  $descripcion = isset($_POST["descripcion"]) ? strtoupper($_POST["descripcion"]) : "";
  $sql="UPDATE tbl_movil_segmentos set nombre = '$nombre', descripcion = '$descripcion' WHERE id = $id_segmento";
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'MODIFICO', strtoupper("$sql"));
  $mysqli->query($sql);
  header('location: ../vistas/movil_gestion_segmentos_vista.php?msj=2');

} else { // insertar datos
  $nombre = isset($_POST["nombre"]) ? strtoupper($_POST["nombre"]) : "";
  $descripcion = isset($_POST["descripcion"]) ? strtoupper($_POST["descripcion"]) : "";
  $creadopor = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : "";
  $tipo_persona = isset($_POST["TP"]) ? $_POST["TP"] : "";
  $genero = isset($_POST["genero"]) ? $_POST["genero"] : "";

///Logica para el que se repite
$sqlexiste = "select count(nombre) as nombre from tbl_movil_segmentos where nombre='$nombre'";
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

/* Logica para que no acepte campos vacios */
if ($_POST['nombre']  <> ' ' and  $_POST['descripcion'] <> '') {

  /* Condicion para que no se repita el rol*/
  if ($existe['nombre'] == 1) {
    //redireccion ya que el nombre segmento existe
 	header('location: ../vistas/movil_crear_segmento_vista.php?msj=1'); 
  } else {
    /* Query para que haga el insert*/
    $sql = "INSERT into tbl_movil_segmentos VALUES (null,'$nombre','$descripcion','$creadopor',sysdate())";
    $resultado = $mysqli->query($sql);
    if ($resultado == true) {
      bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto,'inserto', strtoupper("$sql"));
      header('location: ../vistas/movil_llenar_segmento_vista.php?msj=2');
    } else {
      echo "Error: " . $sql;
    }
  }
} else {
  header('location: ../vistas/movil_crear_segmento_vista.php?msj=3');
}

}
ob_end_flush();
