<?php 
ob_start();
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');




$nombre_producto="";
if (isset($_GET['nombre_producto'])) {
    $nombre_producto = $_GET['nombre_producto'];
    // $id_caracteristica_producto = $_GET['id_caracteristica_producto'];
}

// $id="";
// if (isset($_GET['id_caracteristica_producto'])) {
//     $id_caracteristica_producto = $_GET['id_caracteristica_producto'];
// }
// echo ($_GET['nombre_producto']);
$Id_objeto=195;

if (permisos::permiso_eliminar($Id_objeto)=='0') {

  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso ",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                                               window.location = "../vistas/gestion_preguntas_vista.php";

                            </script>';
}
else
{



// //llamamos al procedmiento almacenado para eliminar r = 

  $sql="call proc_eliminar_cancelar_producto_caracteristica('$nombre_producto');";
  $resultado = $mysqli->query($sql);
	if($resultado === TRUE){
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'CANCELO' , 'LOS DATOS DEL PRODUCTO '.($nombre_producto).' ');

                        	echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"La operacion se cancelo correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 6000
                                });
                                $(".FormularioAjax")[0].reset();
               window.location = "../vistas/gestion_producto_vista.php";

                            </script>'
                            ;                      

                        }else{
                        	echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"No se realizo el proceso",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 5500
                                    });
                                     $(".FormularioAjax")[0].reset();
                                </script>';
                        }
    }

   
ob_end_flush();
?>