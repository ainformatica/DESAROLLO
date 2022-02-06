<?php

session_start();
ob_start();

require_once ('../clases/Conexion.php');
require_once ('../clases/funcion_bitacora.php');

$Id_objeto=214;

$num_inventario=$_SESSION['lo_que_busco'];
 
 /* traer el id_detalle */
$sql = "select id_detalle as id_detalle from tbl_detalle_adquisiciones where numero_inventario='$num_inventario'";
$resultado_inv = $mysqli->query($sql);
$row = $resultado_inv->fetch_array(MYSQLI_ASSOC);
$id_detalle = $row['id_detalle'];

$id_usuario=$_SESSION['id_usuario'];
$id_usuario_responsable=$_SESSION['id_usuario_responsable'];
$motivo=strtoupper ($_POST['motivo']);
$id_ubicacion=strtoupper ($_POST['cmb_id_ubicacion']);
$fecha_asignacion=strtoupper ($_POST['fecha_asignacion']);
$asignado='1';


///Logica para el que se repite
//$sqlexiste = ("SELECT COUNT(id_detalle) AS id_detalle 
//FROM tbl_detalle_adquisiciones WHERE 
//numero_inventario = '$num_inventario' and asignado = 1");
//Obtener la fila del query
//$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));


// echo $num_inventario;
// echo $id_detalle;
// echo $id_usuario;
// echo $id_usuario_responsable_previo;
// echo $id_usuario_responsable;
// echo $motivo_previo;
// echo $motivo;
// echo $id_ubicacion_previa;
// echo $id_ubicacion;
// echo $fecha_asignacion_previa;
// echo $fecha_asignacion;


// $sql = "call proc_insertar_asignacion('$id_detalle','$id_usuario','$id_usuario_responsable', '$motivo', '$id_ubicacion', '$fecha_asignacion')";
// $resultado = $mysqli->query($sql);
// $_SESSION['producto'] ="";
// $_SESSION['caracteristicas']="";
	


        if (empty($_POST['numero_inventario'])) {
          echo '<script type="text/javascript">
          swal({
            title:"",
            text:"Debe buscar un producto para su asignación.",
            type: "warning",
            showConfirmButton: false,
            timer: 3000
          });
        </script>';
        }
           else if  ($_POST['motivo']<> '' and $_POST['fecha_asignacion']> ''  and $_POST['txt_persona_responsable']<> '' and $_POST['cmb_id_ubicacion']> 0)
              {
              /* Query para que haga el insert*/ 
              $sql = "call proc_insertar_asignacion('$id_detalle','$id_usuario','$id_usuario_responsable', '$motivo', '$id_ubicacion', '$fecha_asignacion')";
              $resultado = $mysqli->query($sql);

                        if($resultado === TRUE) 
                        {
                          bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'Insertó' , 'una nueva asignación para el detalle de adquisición No. '.$num_inventario.'');                      
                          
                          $_SESSION['producto'] ="";
                          $_SESSION['caracteristicas']="";
                          $_SESSION['lo_que_busco']="";

                          echo '<script type="text/javascript">              
                          window.location = "../vistas/gestion_asignacion_vista.php";
                          $(".FormularioAjax")[0].reset();
                          </script>';


                          } 
                          else 
                            {
                        echo "Error: " . $sql ;
                        }
            }else
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
              
              ob_end_flush()
?>