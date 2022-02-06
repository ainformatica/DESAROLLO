<?php

   
	session_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_bitacora.php');

  $Id_objeto=209; 
 
//$buscador = strtoupper($_POST['palabra']);
$num_inventario=$_SESSION['lo_que_busco'];

 
$sql = "select id_detalle as id from tbl_detalle_adquisiciones where numero_inventario='$num_inventario';";
$resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
$row = $resultado->fetch_array(MYSQLI_ASSOC);


$sql = "select id_estado as estado from tbl_estado where estado='procesado';";
$resultado = $mysqli->query($sql);
    /* Manda a llamar la fila */
$fila = $resultado->fetch_array(MYSQLI_ASSOC);
    


$hoy= date("Y-m-d");
$Descripcion=mb_strtoupper ($_POST['descripcion']);
$estado=$fila['estado'];
$usuario=$_SESSION['id_usuario'];
$id_detalle=$row['id'];
$fecha= ($_POST['fecha']);	
	
//echo $Descripcion.'    ...        '.$estado.'     ..    '.$usuario.'     ...       '.$id_detalle.'       ...     '.$fecha;
///verificar si el producto ya fue dado de baja
$sqlexiste=("select count(id_detalle) as detalle  from tbl_motivo_salida where id_detalle='$id_detalle'");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



if (empty($num_inventario)) {
  $fecha="";
        echo '<script type="text/javascript">
        swal({
           title:"",
           text:"Debe buscar un producto para su anulación",
           type: "warning",
           showConfirmButton: false,
           timer: 3000
        });
        window.location = "../vistas/crear_salida_vista.php";

                $(".FormularioAjax")[0].reset();
    </script>';
    $fecha="";
}else  if  ($_POST['descripcion']<> "" and $_POST['fecha']<> "" and $num_inventario<>"")
{

          /* Condicion para que no se repita el producto*/
            if ($existe['detalle']==1)
            {
          
            echo '<script type="text/javascript">
                            swal({
                              title:"",
                              text:"Este Producto ya fué dado de baja",
                              type: "error",
                              showConfirmButton: false,
                              timer: 3000
                            });
                        </script>';
            }
            else
            {
              /* Query para que haga el insert y para que envie a la tabla transacciones que ese id producto va de salida*/ 
              $sql = "call proc_insertar_salida_producto2('$Descripcion','$estado','$usuario','$id_detalle','$fecha','$num_inventario')";
              $resultado = $mysqli->query($sql);


                              

              if($resultado === TRUE) 
              {
                        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INSERTO' , 'UNA NUEVA SALIDA,DIÓ DE BAJA Al PRODUCTO CON NUM INVENTARIO '.$num_inventario.'');
                      
                    echo '<script type="text/javascript">
                        swal({
                            title: "",
                            text: "Los datos  se almacenaron correctamente",
                            type: "success",
                            showConfirmButton: false,
                            timer: 3000
                        });
                        window.location = "../vistas/gestion_salida_vista.php";

                        $(".FormularioAjax")[0].reset();
                    </script>';

                              

                } 
                else 
                  {
                echo "Error: " . $sql ;
                }
            }//cierre
        
        
                                        
}
/* elseif ( $_POST['fecha_salida']>$hoy )
{

  echo '<script type="text/javascript">
  swal({
  title:"",
  text:"Fecha Invalida",
  type: "warning",
  showConfirmButton: false,
  timer: 3000
  });
  

  


  </script>';
} */
else
{
echo '<script type="text/javascript">
                                swal({
                                title:"",
                                text:"Lo sentimos tiene campos por rellenar",
                                type: "warning",
                                showConfirmButton: false,
                                timer: 3000
                                });
                                

                                


                                </script>';

}

ob_end_flush();
?>    
