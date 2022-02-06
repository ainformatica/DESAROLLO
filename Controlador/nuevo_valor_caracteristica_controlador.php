<?php
        ob_start();
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');


        // $id_detalle_caracteristica = $_GET['id_detalle_caracteristica'];
        
          $Id_objeto=218; 
          $caracteristica = $_GET['caracteristica'];
          $numero_inventario = $_SESSION['numero_inventario_'];

          $sql ="SELECT id_detalle from tbl_detalle_adquisiciones where numero_inventario='$numero_inventario'";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $id_detalle = $row['id_detalle'];



          $sql ="SELECT c.id_caracteristica_producto as id_caracteristica_producto FROM tbl_tipo_caracteristica a INNER JOIN tbl_detalle_adquisiciones b INNER JOIN tbl_caracteristicas_producto c WHERE b.id_detalle = $id_detalle and b.id_producto = c.id_producto and c.id_tipo_caracteristica = a.id_tipo_caracteristica and a.tipo_caracteristica = '$caracteristica'";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $id_caracteristica_producto=$row['id_caracteristica_producto'];

          $sql="SELECT validacion from tbl_tipo_caracteristica where tipo_caracteristica='$caracteristica'";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $validacion=$row['validacion'];

          $valor = $_POST['txt_valor'];

          $sqlexiste="select count(id_caracteristica_producto) as id_caracteristica_producto  from tbl_detalle_caracteristica where id_caracteristica_producto='$id_caracteristica_producto' and id_detalle='$id_detalle'";
          //Obtener la fila del query
         $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
        //   echo $caracteristica;
        //   echo $id_detalle;
        //   echo $id_caracteristica_producto;
        //   echo $valor;


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
         
                
                /* Condicion para que no se repita el rol*/
                   if ($existe['id_caracteristica_producto']== 1)
                    {
                        echo '<script type="text/javascript">
                                    swal({
                                    title:"",
                                    text:"Lo sentimos esta caracteristica ya tiene su valor",
                                    type: "error",   
                                    showConfirmButton: false,
                                    timer: 3000
                                    });
                                </script>';
                    
                    }
                    else
                    {
         
             $sql = "call proc_insertar_detalle_caracteristica('$id_caracteristica_producto','$id_detalle','$valor')";
                        $resultado = $mysqli->query($sql);
         

                        if($resultado === TRUE) 
                      {
                                // bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA UBICACION '. $ubicacion.'');

                    /*   require"../contenidos/crearRol-view.php"; 
                    header('location: ../contenidos/crearRol-view.php?msj=2');*/
                    header("location:../vistas/editar_detalle_adquisicion_vista.php?numero_inventario= $numero_inventario&msj=11");
                      
                  } 
                  else 
                  {
                    echo "Error: " . $sql ;
                  }

                }

            }

            else
            {
                header("location:../vistas/editar_detalle_adquisicion_vista.php?numero_inventario=$numero_inventario&msj=10");
            }











        /* if ($Combo>0)
        {               
                //validacion para que el numeo de inventario no se repita
                $sqlexiste=("select count(numero_inventario) as numero_inventario from tbl_detalle_adquisiciones where numero_inventario ='$numero'");

                $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));
                 
                if ($existe['numero_inventario']==1)
                {
                        header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=1");

                }else
                {
                        $sql = "call proc_insertar_detalle_adquisicion('$id_adquisicion','$producto','$numero','$id_estado')";
                        $resultado = $mysqli->query($sql);
                        
                        if ($resultado === true) {
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL DETALLE DE ADQUISICION '.$numero.'');

                
                                header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=2");
                        } else {
                                header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=3");
                        }   

                }

                



        }else{       
                header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=4");
        } */
         
    
        ob_end_flush();
        
?>







       
    
   