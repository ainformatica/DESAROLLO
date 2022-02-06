<?php
ob_start();
 session_start();

 require_once ('../clases/Conexion.php');
 require_once ('../clases/funcion_bitacora.php'); 

        $Id_objeto=217 ;


$tipo_transaccion=mb_strtoupper ($_POST['cb_tipo_transaccion']);
$producto=mb_strtoupper ($_POST['cb_producto']);
$cantidad=mb_strtoupper ($_POST['txt_cantidad']);

   ///obtener la existencia del producto
   $sql = "SELECT existencia as existencia FROM tbl_inventario WHERE id_producto = '$producto'";
   $resultado = $mysqli->query($sql);
   $row = $resultado->fetch_array(MYSQLI_ASSOC);
   $existencia=$row['existencia'];
 
//validacion lado del servidor
$patron_texto = "/^[0123456789\s]+$/";
if( preg_match($patron_texto, $_POST['txt_cantidad']) )
    {

          ///Logica para el que se repite
        //   $sqlexiste=("select count(tipo_transaccion) as tipo_transaccion  from tbl_tipo_transaccion where tipo_transaccion='$tipo_transaccion'");
        //   //Obtener la fila del query
        //   $existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));

          /* Logica para que no acepte campos vacios */
          if ($_POST['txt_cantidad'] <>' ' and ($_POST['cb_producto']) >0 and ($_POST['cb_tipo_transaccion']>0))
          {

            if(($cantidad > $existencia) and ($tipo_transaccion == 2)){
              header("location:../vistas/transaccion_kardex_vista.php?msj=6");
            }else{
                   
                      /* Query para que haga el insert*/
                    $sql = "call proc_insertar_transaccion_descartable('$tipo_transaccion','$producto','$cantidad')";
                            $resultado = $mysqli->query($sql);
                  
                    
                      if($resultado === TRUE) 
                      {
                            //   bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'LA TRANSACCION'. $tipo_transaccion.'');

                    /*   require"../contenidos/crearRol-view.php"; 
                 header('location: ../contenidos/crearRol-view.php?msj=2');*/
                 header("location:../vistas/transaccion_kardex_vista.php?msj=1");
                      
                  } 
                  else 
                  {
                    echo "Error: " . $sql ;
                  }

      }
          }

          else
          {
            header("location:../vistas/transaccion_kardex_vista.php?msj=3");
          }
        }
     
  else{   
    header("location:../vistas/transaccion_kardex_vista.php?msj=4");
  }              

  ob_end_flush();
?>    
