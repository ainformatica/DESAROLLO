<?php

 ob_start();
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=188;


$estado =mb_strtoupper ($_POST['txt_estado1']);


$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
if( preg_match($patron_texto, $_POST['txt_estado1']) )
{
 
            ///Logica para el que se repite
            $sqlexiste=("select count(estado) as estado  from tbl_estado where estado ='$estado '");
            //Obtener la fila del query
            $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



            /* Logica para que no acepte campos vacios */
            if ($_POST['txt_estado1']  <>' ')
            {

            
              /* Condicion para que no se repita el estado*/
                if ($existe['estado']== 1)
                {
                    echo '<script type="text/javascript">
                                swal({
                                  title:"",
                                  text:"Lo sentimos el estado ya existe",
                                  type: "error",
                                  showConfirmButton: false,
                                  timer: 3000
                                });
                            </script>';
                
                }
                else
                {
       
                    /* Query para que haga el insert*/
                  $sql = "call proc_insertar_estado('$estado')";
                          $resultado = $mysqli->query($sql);
                
                  
                    if($resultado === TRUE) 
                    {
                              bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL ESTADO '. $estado.'');

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
                                          window.location = "../vistas/mantenimiento_tipo_estado_vista.php";
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