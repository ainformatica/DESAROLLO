<?php 
require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora_movil.php');
if(!isset($_SESSION)){ 
   session_start();
}
ob_start();
//id_objeto vista segmentos
$Id_objeto = 171;
if (isset($_POST)) {
   if ($_POST['funcion']=='eliminar') {
      $id = (int)$_POST['id'];
                //se ejecuta el sql respectivo
                $sql = "DELETE FROM tbl_movil_segmentos where id = $id";
                $resultado = $mysqli->query($sql);
                bitacora_movil::evento_bitacora($_SESSION['id_usuario'],$Id_objeto,'ELIMINO',strtoupper("$sql"));
                if ($resultado) {
                    echo 'hola mundo';
                }else{
                    echo 'f';
                }
   }



}else{
   echo 'no existe el metodo post';
}

ob_end_flush();
?>