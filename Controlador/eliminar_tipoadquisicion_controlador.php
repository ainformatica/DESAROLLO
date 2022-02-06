<?php 

ob_start();

session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');




$id="";
if (isset($_GET['tipo_adquisicion'])) {
    $tipo_adquisicion = $_GET['tipo_adquisicion'];
}

$Id_objeto=187;

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
                                               window.location = "../vistas/mantenimiento_tipoadquisicion_vista.php";

                            </script>';
}
else
{



//llamamos al procedmiento almacenado para eliminar registros de tipo adquisicion
  $sql = "call proc_eliminar_tipo_adquisicion('$tipo_adquisicion'); ";
  $resultado = $mysqli->query($sql);
	if($resultado === TRUE){
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO' , 'EL TIPO ADQUISICION '. $tipo_adquisicion.' ');

                        	echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Los datos se eliminaron correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
               window.location = "../vistas/mantenimiento_tipoadquisicion_vista.php";

                            </script>'
                            ;                      

                        }else{
                        	echo '<script type="text/javascript">
                                    swal({
                                       title:"",
                                       text:"El registro no puede ser eliminado",
                                       type: "error",
                                       showConfirmButton: false,
                                       timer: 3000
                                    });
                                     $(".FormularioAjax")[0].reset();
                                </script>';
                        }
}


ob_end_flush();

?>