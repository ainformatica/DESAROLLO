<?php

ob_start();

session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_permisos.php');
require_once ('../clases/funcion_bitacora.php');

$Id_objeto=210;

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
                                                 window.location = "../vistas/pagina_principal_vista.php";
  
                              </script>';
  }else{



  $id="";
  $id_adquisicion=$_GET['id_adquisicion'];
  $estado=$_GET['estado'];

 ///obtener el id_estado
 $sql = "SELECT * FROM tbl_adquisiciones WHERE id_adquisicion = $id_adquisicion";
 $resultado = $mysqli->query($sql);
 $row = $resultado->fetch_array(MYSQLI_ASSOC);
 $descripcion=$row['descripcion_adquisicion'];





$sqlproducto= "SELECT DISTINCTROW id_producto FROM tbl_detalle_adquisiciones WHERE id_adquisicion=$id_adquisicion";
$resultadoproducto = $mysqli->query($sqlproducto);

while ($row = $resultadoproducto->fetch_array(MYSQLI_ASSOC)) {

  $id_producto=$row['id_producto'];
  $sqltransaccion= "call proc_anular_adquisicion('$id_producto','$id_adquisicion')";

  $resultadotransaccion = $mysqli->query($sqltransaccion);

}

      bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'ANULO' , 'LA ADQUISICION CON DESCRIPCION: '.$descripcion.'');

          echo '<script type="text/javascript">
          swal({
               title:"",
               text:"Adquisición Anulada Exitosamente",
               type: "success",
               showConfirmButton: false,
               timer: 2000
            });
            $(".FormularioAjax")[0].reset();
          window.location = "../vistas/gestion_adquisicion_vista.php";

        </script>'
        ;          

      }
      
        ob_end_flush();
     
        ?>