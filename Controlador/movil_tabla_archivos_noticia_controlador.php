<?php
if(!isset($_SESSION)){ 
    session_start();
}
ob_start();
require_once('../clases/Conexion.php'); 


if (isset($_POST['funcion'])) {
    if ($_POST['funcion']=='eliminar') {
        eliminar();
    }
}
function eliminar(){
    $id_noticia = (int)$_POST['id_noticia'];
    $id_recurso = (int)$_POST['id_recurso'];
    global $mysqli;
  $sql = "DELETE FROM tbl_movil_noticia_recurso WHERE recurso_id = $id_recurso and noticia_id = $id_noticia";
  $resultado = $mysqli->query($sql);
  if ($resultado) {
      return 'hola_mundo';
  }else{
      return '';
  }
}
ob_end_flush();
?>
