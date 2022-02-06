<?php 


ob_start();
session_start();


require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');



$Id_objeto=218;


  ///obtener el id_adquisicion
  $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
  $resultado = $mysqli->query($sql);
  $row = $resultado->fetch_array(MYSQLI_ASSOC);
  $id_adquisicion=$row['id_adquisicion'];
 

  ///obtener la descripcion de adquisicion
  $sql = "SELECT descripcion_adquisicion as descripcion FROM tbl_adquisiciones where id_adquisicion = $id_adquisicion ";
  $resultado = $mysqli->query($sql);
  $row = $resultado->fetch_array(MYSQLI_ASSOC);
  $descripcion=$row['descripcion'];




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
                                               window.location = "../vistas/vistas/pagina_principal_vista.php";

                            </script>';
}
else
{


// //llamamos al procedmiento almacenado para eliminar r = 

  $sql="call proc_cancelar_detalle_caracteristicas_adquisicion($id_adquisicion);";
  $resultado = $mysqli->query($sql);
	if($resultado === TRUE){
     bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'CANCELO' , 'TODOS LOS DATOS RELACIONADOS DE LA ADQUISICION CON DESCRIPCION: '.$descripcion.' ');

                        	echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"La operacion se canceló correctamente",
                                   type: "success",
                                   showConfirmButton: false,
                                   timer: 6000
                                });
                                $(".FormularioAjax")[0].reset();
               window.location = "../vistas/gestion_adquisicion_vista.php";

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