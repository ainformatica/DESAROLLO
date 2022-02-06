<?php 

ob_start();
session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');




$Id_objeto=218; 
$numero = $_GET['numero_inventario'];
// $id_detalle = $_SESSION['id_detalle_'];
// echo $id_detalle;
// $Id_objeto=208;

if (permisos::permiso_eliminar($Id_objeto)=='0')
{

  echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso para eliminar",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                                $(".FormularioAjax")[0].reset();
                                               window.location = "../vistas/pagina_principal_vista.php";

                            </script>';
  }
else
{
                //llamamos al procedmiento almacenado para eliminar registros de tipo adquisicion
          $sql = "CALL proc_eliminar_detalle_adquisicioness('$numero'); ";
          $resultado = $mysqli->query($sql);
          if($resultado === TRUE){
            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ELIMINO' , 'EL ELEMENTO DE INVENTARIO: '.$numero.' ');
            // header("location:../vistas/crear_caracteristicas_producto_vista.php?msj=5");
            	echo '<script type="text/javascript">
                                
                                   $(".FormularioAjax")[0].reset();
                                   window.location = "../vistas/crear_detalle_adquisicion_vista.php?msj=5";

                            </script>';
                      
                    
          
                                                       
          
          }else{
            header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=3");


          }

        
    }

    ob_end_flush();

    ?>