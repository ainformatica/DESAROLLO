<?php

 ob_start();
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=191;


$tipo_producto=strtoupper ($_POST['txt_tipo_producto1']);


$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
if( preg_match($patron_texto, $_POST['txt_tipo_producto1']) )
{
 
///Logica para el que se repite
                $sqlexiste=("select count(tipo_producto) as tipo_producto  from tbl_tipo_producto where tipo_producto='$tipo_producto'");
                //Obtener la fila del query
                $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



                /* Logica para que no acepte campos vacios */
                if ($_POST['txt_tipo_producto1']  <>' ')
                {

                
                  /* Condicion para que no se repita el rol*/
                    if ($existe['tipo_producto']== 1)
                    {
                        echo '<script type="text/javascript">
                                    swal({
                                      title:"",
                                      text:"Lo sentimos el tipo de producto ya existe",
                                      type: "error",
                                      showConfirmButton: false,
                                      timer: 3000
                                    });
                                </script>';
                    
                    }
                    else
                    {
                      
                          /* Query para que haga el insert*/
                        $sql = "call proc_insertar_tipo_producto('$tipo_producto')";
                                $resultado = $mysqli->query($sql);
                      
                        
                          if($resultado === TRUE) 
                          {
                                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL TIPO PRODUCTO '. $tipo_producto.'');

                        /*   require"../contenidos/crearRol-view.php"; 
                        header('location: ../contenidos/crearRol-view.php?msj=2');*/
                        echo '<script type="text/javascript">
                                              swal({
                                                  title:"",
                                                  text:"Los datos se almacenaron correctamente",
                                                  type: "success",
                                                  showConfirmButton: false,
                                                  timer: 3000
                                                });
                                                $(".FormularioAjax")[0].reset();
                                                window.location = "../vistas/mantenimiento_tipo_producto_vista.php";
                                            </script>';
                          
                      } 
                      else 
                      {
                        echo "Error: " . $sql ;
                      }

                    }


                } 

                else
                {
                  echo '<script type="text/javascript">
                                                    swal({
                                                      title:"",
                                                      text:"Lo sentimos tiene campos por rellenar",
                                                      type: "error",
                                                      showConfirmButton: false,
                                                      timer: 3000
                                                    });
                                                </script>';
                }
}

else{   
  echo '<script type="text/javascript">
  swal({
    title:"",
    text:"El nombre solo puede contener espacios y letras",
    type: "error",
    showConfirmButton: false,
    timer: 3000
  });
</script>';
}              


ob_end_flush();


?>