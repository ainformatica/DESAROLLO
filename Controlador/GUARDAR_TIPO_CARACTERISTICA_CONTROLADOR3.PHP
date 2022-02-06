<?php
 ob_start();
 session_start();
 

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=195 ;


$tipo_caracteristica=mb_strtoupper ($_POST['txt_tipo_caracteristica1']);
$tipo_dato=$_POST['cb_tipo_dato'];
 
$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚ_äëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ_\s]+$/";
if( preg_match($patron_texto, $_POST['txt_tipo_caracteristica1']) )
{ 


                    ///Logica para el que se repite
                    $sqlexiste=("select count(tipo_caracteristica) as tipo_caracteristica  from tbl_tipo_caracteristica where tipo_caracteristica='$tipo_caracteristica'");
                    //Obtener la fila del query
                    $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



                    /* Logica para que no acepte campos vacios */
                    if ($_POST['txt_tipo_caracteristica1']  <>"" and $_POST['cb_tipo_dato']>0 )
                    {

                    
                    /* Condicion para que no se repita el tipo caracteristica*/
                        if ($existe['tipo_caracteristica']== 1)
                        
                        {
                            header("location:../vistas/editar_caracteristicas_producto_vista.php?msj=1");

                        }
                        else
                        {
                        
                                    /* Query para que haga el insert*/
                                    $sql = "call proc_insertar_tipo_caracteristica('$tipo_caracteristica','$tipo_dato')";
                                    $resultado = $mysqli->query($sql);
                        
                            
                                if($resultado == TRUE) 
                            {
                                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'CREO' , 'UNA NUEVA CARACTERISTICA:  '. $tipo_caracteristica.'');

                        
                                    header("location:../vistas/editar_caracteristicas_producto_vista.php?msj=2");
      
                                    

                            
                                } 
                                else 
                                {
                                // echo "Error: " . $sql ;
                                header("location:../vistas/editar_caracteristicas_producto_vista.php?msj=3");

                                }

                        }


                    } 

                    else if ($_POST['cb_tipo_dato']<0)
                    {
                        header("location:../vistas/editar_caracteristicas_producto_vista.php?msj=7");

                    }
                    else
                        {
                            header("location:../vistas/editar_caracteristicas_producto_vista.php?msj=4");

                        }
}

else{   
    header("location:../vistas/editar_caracteristicas_producto_vista.php?msj=6");

}    


ob_end_flush();
?>