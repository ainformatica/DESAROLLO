<?php

 ob_start();
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

$Id_objeto=199;


$tipo_caracteristica=mb_strtoupper ($_POST['txt_tipo_caracteristica1']);

$tipo_dato=$_POST['cb_tipo_dato'];

$patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙÑ_\s]+$/";
if( preg_match($patron_texto, $_POST['txt_tipo_caracteristica1']) )
{



        ///Logica para el que se repite
        $sqlexiste=("select count(tipo_caracteristica) as tipo_caracteristica  from tbl_tipo_caracteristica where tipo_caracteristica='$tipo_caracteristica'");
        //Obtener la fila del query
        $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



        /* Logica para que no acepte campos vacios */
        if ($_POST['txt_tipo_caracteristica1']  <>"" and $_POST['cb_tipo_dato']>0)
        {

        
          /* Condicion para que no se repita el tipo caracteristica*/
            if ($existe['tipo_caracteristica']== 1)
            {
                echo '<script type="text/javascript">
                            swal({
                              title:"",
                              text:"Lo sentimos esta caracteristica ya existe",
                              type: "error",
                              showConfirmButton: false,
                              timer: 3000
                            });
                        </script>';
            
            }
            else
            {
              
                  /* Query para que haga el insert*/
                $sql = "call proc_insertar_tipo_caracteristica('$tipo_caracteristica','$tipo_dato')";
                        $resultado = $mysqli->query($sql);
              
                
                  if($resultado === TRUE) 
                  {
                          bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'CREO' , 'UNA NUEVA CARACTERISTICA:   '. $tipo_caracteristica.'');

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
                                        window.location = "../vistas/mantenimiento_tipo_caracteristica_vista.php";
                                    </script>';
                  
              } 
              else 
              {
                echo "Error: " . $sql ;
              }

            }


        } 

          else if ($_POST['cb_tipo_dato']==0)
          {
                echo '<script type="text/javascript">
                swal({
                  title:"",
                  text:"Seleccione un tipo de dato",
                  type: "error",
                  showConfirmButton: false,
                  timer: 3000
                });
            </script>';
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