<?php
require_once('../clases/Conexion.php');
//funcion para la utilizacion de la tabla parametros
function parametrizacion($dato){
   global $mysqli;
   $sql = "SELECT valor FROM tbl_movil_parametros WHERE parametro = '$dato'";
   $rspta = $mysqli->query($sql);
   $row = $rspta->fetch_assoc();
   return $row['valor'];
}

?>