<?php
        ob_start();
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        
          $Id_objeto=218; 
          ///obtener el id_adquisicion
        //   $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
        //   $resultado = $mysqli->query($sql);
        //   $row = $resultado->fetch_array(MYSQLI_ASSOC);
        //   $id_adquisicion = $row['id_adquisicion'];
      $adquisicion=$_SESSION['id'];
          // $id_adquisicion = $_GET['id_adquisicion'];
          // echo $adquisicion;
          // $id_detalle = $_SESSION['id_detalle_'];
          // echo $id_detalle;
          
          
          // // $id_detalle=$_SESSION'id_detalle'];
          // // echo $id_detalle;

         
        
                          $sqlexiste="SELECT COUNT(a.id_detalle) as contador FROM tbl_detalle_adquisiciones a INNER JOIN tbl_detalle_caracteristica b where a.id_detalle=b.id_detalle and id_adquisicion= '$adquisicion'";

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
                                echo '<script type="text/javascript">
                                swal({
                                     title:"",
                                     text:"Actualización Finalizada!",
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
                              
                        
               
        
                   
     