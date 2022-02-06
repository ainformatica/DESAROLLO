<?php

 ob_start();
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 
 
 $Id_objeto=186;
 $tipo_adquisicion=mb_strtoupper ($_POST['txt_tipoadquisicion1']);
 //mb_st.. para caracteres especiales convierte a mayusculas sin importar la tilde

 //$aErrores = array();
     //$aMensajes = array();
    // Patrón para usar en expresiones regulares (admite letras acentuadas y espacios):
    
    
    
    $patron_texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
     if( preg_match($patron_texto, $_POST['txt_tipoadquisicion1']) )
     {
      //$aMensajes[] = "Nombre: [".$_POST['txt_tipoadquisicion1']."]";

                        ///Logica para el que se repite
                  $sqlexiste=("select count(tipo_adquisicion) as tipo_adquisicion  from tbl_tipo_adquisicion where tipo_adquisicion='$tipo_adquisicion'");
                  //Obtener la fila del query
                  $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



                  /* Logica para que no acepte campos vacios */
                  if ($_POST['txt_tipoadquisicion1']  <>' ')
                  {

                  
                    /* Condicion para que no se repita el tipo adquisicion*/
                      if ($existe['tipo_adquisicion']== 1)
                      {
                          echo '<script type="text/javascript">
                                      swal({
                                        title:"",
                                        text:"Lo sentimos el tipo adquisición ya existe",
                                        type: "error",
                                        showConfirmButton: false,
                                        timer: 3000
                                      });
                                  </script>';
                      
                      }
                      else
                      {
                        
                            /* Query para que haga el insert*/
                          $sql = "call proc_insertar_tipo_adquisicion('$tipo_adquisicion')";
                                  $resultado = $mysqli->query($sql);
                        
                          
                            if($resultado === TRUE) 
                            {
                                    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'EL TIPO ADQUISICION'. $tipo_adquisicion.'');

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
                                                  window.location = "../vistas/mantenimiento_tipoadquisicion_vista.php";
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
 

     


        
