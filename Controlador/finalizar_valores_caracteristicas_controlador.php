<?php
        ob_start();
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        $Id_objeto=218; 
         
        //   $caracteristica = $_GET['caracteristica'];
          $id_detalle = $_GET['id_detalle'];


          $sql ="SELECT id_producto as id_producto from tbl_detalle_adquisiciones where id_detalle= $id_detalle";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $id_producto=$row['id_producto'];

          $sql="SELECT COUNT(id_caracteristica_producto) as id_caracteristica_producto from tbl_caracteristicas_producto  where  id_producto= $id_producto";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $contador_caracteristicas=$row['id_caracteristica_producto'];



          $sql="SELECT COUNT(a.id_detalle_caracteristica) as id_detalle_caracteristica from tbl_detalle_caracteristica a INNER JOIN tbl_detalle_adquisiciones b where a.id_detalle=b.id_detalle and a.id_detalle=$id_detalle";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $contador_detalles=$row['id_detalle_caracteristica'];

         

                          
                   if ($contador_detalles < $contador_caracteristicas)
                    {
                        header("location:../vistas/crear_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=11");
                    
                    }
                    else{
                    header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=10");
                    
                    }
         
    
                    ob_end_flush();
        
?>





