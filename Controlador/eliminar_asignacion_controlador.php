<?php 

ob_start();
session_start();



require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');

//$id="";
 if (isset($_GET['id_asignacion'])) {
    $id_asignacion = $_GET['id_asignacion'];
} 


 $Id_objeto=212;

if (permisos::permiso_eliminar($Id_objeto)=='0') {

  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso para eliminar",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                                               window.location = "../vistas/gestion_asignacion_vista.php";

                            </script>';
}
else
{

//llamamos al procedmiento almacenado para eliminar registros de tipo adquisicion
  $sql = "CALL proc_eliminar_asignaciones('$id_asignacion');";
  $resultado = $mysqli->query($sql);
  
	if($resultado === TRUE){

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO ' , 'LA ASIGNACION '.$id_asignacion.' ');

                        	echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos se eliminaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
               window.location = "../vistas/gestion_asignacion_vista.php";

                            </script>'
                            ;                      

                        }else{
                        	echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"No se realizó el proceso, el registro a eliminar tiene datos en otras tablas",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 1500
                                    });
                                     $(".FormularioAjax")[0].reset();
                                </script>';
                        }
}

ob_end_flush(); 
?> 