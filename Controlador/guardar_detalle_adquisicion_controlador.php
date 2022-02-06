<?php
        ob_start();
        session_start();

        require_once ('../clases/Conexion.php');
        require_once ('../clases/funcion_bitacora.php');
        
        
          $Id_objeto=218; 

          ///obtener el id_estado
          $sql = "SELECT * FROM tbl_estado WHERE estado = 'bueno'";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $id_estado=$row['id_estado'];

          ///obtener el id_adquisicion
          $sql = "SELECT MAX(id_adquisicion) as id_adquisicion FROM tbl_adquisiciones";
          $resultado = $mysqli->query($sql);
          $row = $resultado->fetch_array(MYSQLI_ASSOC);
          $id_adquisicion=$row['id_adquisicion'];

         ///traemos los demás datos
          $Combo=$_POST['cmb_producto'];
          $producto=$Combo;
          $numero=strtoupper($_POST['txt_numero']);



$patron_texto = "/^[a-zA-Z-_áéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ0123456789\s]+$/";
if( preg_match($patron_texto, $_POST['txt_numero']) )
{
    
        if ($Combo>0)
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
                            bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL ELEMENTO DE INVENTARIO: '.$numero.'');

                                //  echo '<script type="text/javascript">
                                //         swal({
                                //                 title: "",
                                //                 text: "Agregado con exito",
                                //                 type: "success",
                                //                 showConfirmButton: false,
                                //                 timer: 3000
                                //                 $(".FormularioAjax")[0].reset();
                                //         });
                                //         </script>';



                                header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=2");
                        } else {
                                header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=3");
                        }   

                }

                



        }else{       
                header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=4");
        }
         
}

else{   
        header("location:../vistas/crear_detalle_adquisicion_vista.php?msj=8");
}   


ob_end_flush();
        
?>







       
    
   