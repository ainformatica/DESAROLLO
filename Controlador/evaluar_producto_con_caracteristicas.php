<?php
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        
          $Id_objeto=195; 
          $nombre_producto="";
          $id_producto="";
          if (isset($_GET['nombre_producto'])) {
              $nombre_producto = $_GET['nombre_producto'];
              // $id_caracteristica_producto = $_GET['id_caracteristica_producto'];
          }
          
          
         
        //   $Producto=$_POST['nombre_prueba']; //el producto que trae

        
                          $sqlexiste="SELECT count(id_tipo_caracteristica) as contador from tbl_caracteristicas_producto TCP,tbl_productos TP where TCP.id_producto=TP.id_producto and nombre_producto='$nombre_producto' ";

                          $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
                           
                          if ($existe['contador']==0)
                          {
                                echo '<script type="text/javascript">
                                swal({
                                     title:"",
                                     text:"Debe agregar por lo menos 1 caracteristica a su producto",
                                     type: "error",
                                     showConfirmButton: false,
                                     timer: 20000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                window.location = "../vistas/crear_caracteristicas_producto_vista.php";
  
                              </script>'
                              ;          
          
                          }
                          else
                          {

                            $sql = "call proc_insertar_producto_inicializado2('$nombre_producto');";
                              $resultado = $mysqli->query($sql);

                                echo '<script type="text/javascript">
                                swal({
                                     title:"",
                                     text:"Proceso Producto Finalizado!",
                                     type: "success",
                                     showConfirmButton: false,
                                     timer: 20000
                                  });
                                  $(".FormularioAjax")[0].reset();
                                window.location = "../vistas/gestion_producto_vista.php";
  
                              </script>'
                              ;    
                              
                              
                                      


                              

                          }

                
          

          
         
        
          
     