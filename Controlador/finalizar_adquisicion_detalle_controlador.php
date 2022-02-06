<?php
        ob_start();
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        
          $Id_objeto=218; 
          ///obtener el id_adquisicion
          $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $id_adquisicion = $row['id_adquisicion'];

          // $id_adquisicion = $_GET['id_adquisicion'];
          // echo $id_adquisicion;
          // $id_detalle = $_SESSION['id_detalle_'];
          // echo $id_detalle;
          $sqldetalle = "SELECT id_detalle as id_detalle FROM tbl_detalle_adquisiciones where id_adquisicion=$id_adquisicion";
          $resultadodetalle = $mysqli->query($sqldetalle);
          $row = $resultadodetalle->fetch_array(MYSQLI_ASSOC);
          $id_detalle= $row['id_detalle'];
          
          // $id_detalle=$_SESSION['id_detalle_'];

          // echo $id_detalle;

        
                          $sqlexiste="SELECT COUNT(b.id_detalle) as contador FROM tbl_detalle_adquisiciones a INNER JOIN tbl_detalle_caracteristica b where a.id_detalle=b.id_detalle and a.id_adquisicion='$id_adquisicion' and a.id_detalle= $id_detalle";

                          $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


                           
                          if ($existe['contador']<1)
                          {
                                echo '<script type="text/javascript">
                                swal({
                                     title:"",
                                     text:"Debe agregar por lo menos 1 detalle de adquisición con sus caracteristicas",
                                     type: "error",
                                     showConfirmButton: false,
                                     timer: 20000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                window.location = "../vistas/crear_detalle_adquisicion_vista.php";
  
                              </script>'
                              ;          
          
                          }
                          else
                          {
                                      $sqlproducto= "SELECT DISTINCTROW id_producto FROM tbl_detalle_adquisiciones WHERE id_adquisicion=$id_adquisicion";
                      $resultadoproducto = $mysqli->query($sqlproducto);

                      while ($row = $resultadoproducto->fetch_array(MYSQLI_ASSOC)) {

                        $id_producto=$row['id_producto'];
                        $sqltransaccion= "call proc_insertar_adquisicion_transaccion('$id_producto','$id_adquisicion')";
                    
                        $resultadotransaccion = $mysqli->query($sqltransaccion);

                      }


                                echo '<script type="text/javascript">
                                swal({
                                     title:"",
                                     text:"Proceso Adquisicion Finalizado!",
                                     type: "success",
                                     showConfirmButton: false,
                                     timer: 20000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                window.location = "../vistas/gestion_adquisicion_vista.php";
  
                              </script>'
                              ;          
              

                          
                              
                                }



                                ob_end_flush();
        
                                ?>

                              
                        
               
        
                   
     