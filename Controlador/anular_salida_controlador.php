
<?php

ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_permisos.php');
require_once('../clases/funcion_bitacora.php');


$Id_objeto = 208;

if (isset($_GET['motivo'])) {

   $motivo = $_GET['motivo'];
}

if (isset($_GET['estado'])) {

   $estado = $_GET['estado'];
}

if (isset($_GET['inventario'])) {

   $inventario = $_GET['inventario'];
}


if ($estado == 'PROCESADO') {
   $sql = "call proc_anular_salidas('$motivo','$inventario')";
   $resultado = $mysqli->query($sql);
   if ($resultado == TRUE) {
      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'ANULÓ', ' LA SALIDA DEL PRODUCTO CON NO.INVENTARIO  ' . $inventario . ' ');



      echo '<script type="text/javascript">
                               swal({
                                    title:"",
                                    text:"Los datos se anularon correctamente",
                                    type: "success",
                                    showConfirmButton: false,
                                    timer: 9000
                                    
                                 });
                                 $(".FormularioAjax")[0].reset();
                window.location = "../vistas/gestion_salida_vista.php";
 
                             </script>';
   } else {
      echo '<script type="text/javascript">
                                     swal({
                                        title:"",
                                        text:"El registro no puede ser eliminado",
                                        type: "error",
                                        showConfirmButton: false,
                                        timer: 3500
                                     });
                                      $(".FormularioAjax")[0].reset();
                                 </script>';
   }
} else if ($estado == 'ANULADO') {
   $sql = "call proc_anular_salida2('$motivo','$inventario')";
   $resultado = $mysqli->query($sql);
   if ($resultado == TRUE) {
      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'RESTAURÓ', 'LA SALIDA DEL PRODUCTO CON NO.INVENTARIO  ' . $inventario . ' ');

                             echo '<script type="text/javascript">
                             swal({
                                  title:"",
                                  text:"Los datos se restauraron correctamente",
                                  type: "success",
                                  showConfirmButton: false,
                                  timer: 3000
                               });
                               $(".FormularioAjax")[0].reset();
                               window.location = "../vistas/gestion_salida_vista.php";
                           </script>';
   } else {
      echo '<script type="text/javascript">
                                     swal({
                                        title:"",
                                        text:"El registro no puede ser eliminado",
                                        type: "error",
                                        showConfirmButton: false,
                                        timer: 3500
                                     });
                                      $(".FormularioAjax")[0].reset();
                                 </script>';
   }
}

ob_end_flush();
?>