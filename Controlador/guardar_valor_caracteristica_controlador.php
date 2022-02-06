<?php
        ob_start();
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        
          $Id_objeto=218; 
          $caracteristica = $_GET['caracteristica'];
          $id_detalle = $_SESSION['id_detalle_'];


          $sql ="SELECT c.id_caracteristica_producto as id_caracteristica_producto FROM tbl_tipo_caracteristica a INNER JOIN tbl_detalle_adquisiciones b INNER JOIN tbl_caracteristicas_producto c WHERE b.id_detalle = $id_detalle and b.id_producto = c.id_producto and c.id_tipo_caracteristica = a.id_tipo_caracteristica and a.tipo_caracteristica = '$caracteristica'";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $id_caracteristica_producto=$row['id_caracteristica_producto'];

          $sql="SELECT validacion from tbl_tipo_caracteristica where tipo_caracteristica='$caracteristica'";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $validacion=$row['validacion'];



          $valor = strtoupper($_POST['txt_valor']);
          $sqlexiste="select count(id_caracteristica_producto) as id_caracteristica_producto  from tbl_detalle_caracteristica where id_caracteristica_producto='$id_caracteristica_producto' and id_detalle='$id_detalle'";
          //Obtener la fila del query
         $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
        //   echo $caracteristica;
        //   echo $id_detalle;
        //   echo $id_caracteristica_producto;




        if ($validacion==1){
                $patron_texto = "/^[a-zA-Z-_áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
        }
        elseif ($validacion==2){
                $patron_texto = "/^[0123456789\s]+$/";
           }
           elseif ($validacion==3){
                $patron_texto = "/^[a-zA-Z-_áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ0123456789\s]+$/";
             }

             
          if (preg_match($patron_texto,$_POST['txt_valor'])){

                          
                   if ($existe['id_caracteristica_producto']== 1)
                    {
                        header("location:../vistas/crear_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=9");
                    
                    }
                    else
                    {
         
             $sql = "call proc_insertar_detalle_caracteristica('$id_caracteristica_producto','$id_detalle','$valor')";
                        $resultado = $mysqli->query($sql);
         

                        if($resultado === TRUE) 
                      {
                                 //bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' .$caracteristica. ' = '. $valor.'');

                    /*   require"../contenidos/crearRol-view.php"; 
            header('location: ../contenidos/crearRol-view.php?msj=2');*/
                //     echo '<script type="text/javascript">
                //                           swal({
                //                               title:"",
                //                               text:"Los datos se almacenaron correctamente",
                //                               type: "success",
                //                               showConfirmButton: false,
                //                               timer: 3000
                //                             });
                //                             header("location:../vistas/crear_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=7");
                //                         </script>';


                header("location:../vistas/crear_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=7");



                  } 
                  else 
                  {
                    echo "Error: " . $sql ;
                  }

                }

        } else {
         
                header("location:../vistas/crear_detalle_adquisicion_vista.php?id_detalle=$id_detalle&msj=8");
            
      }


            
      ob_end_flush();
        
      ?>





