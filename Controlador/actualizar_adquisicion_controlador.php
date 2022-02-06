<?php

ob_start();
session_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');

$Id_objeto=211; 

//$Id_producto=intval( $_GET['id_producto']);
  /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
  $hoy= date("DD/MM/AAAA");
$sql = "SELECT * FROM tbl_estado WHERE estado = 'procesado'";
$resultado = $mysqli->query($sql);
$row = $resultado->fetch_array(MYSQLI_ASSOC);
  

// $id_adquisicion = $_POST['id_adquisicion_'];
$tipo_adquisicion=strtoupper ($_POST['txt_tipo']);
$Descripcion=strtoupper ($_POST['txt_descripcion']);
$fecha=strtoupper ($_POST['txt_fechaAdquisicion']);	
// $estado=$row['id_estado'];	
// $usuario=$_SESSION['id_usuario'];
$id_adquisicion=$_SESSION['id_adquisicion_'];

$_SESSION['id']=$_SESSION['id_adquisicion_'];
// echo $_SESSION['id_adquisicion'];



/* Logica para que no acepte campos vacios */
if  ($_POST['txt_descripcion']<> '' and $_POST['txt_fechaAdquisicion']>0)
{

        
        /* Query para que haga el insert, procedimiento almacenado para ingresar adquisiciomes*/ 
	$sql = "call proc_actualizar_adquisicion('$id_adquisicion','$Descripcion')";
     //CONTIENE LOS DATOS ANTES DE LA ACTUALIZACION DEL PRODUCTO
     $valor="select * from tbl_adquisiciones WHERE id_adquisicion= '$id_adquisicion'";
     $result_valor = $mysqli->query($valor);
     $valor_viejo = $result_valor->fetch_array(MYSQLI_ASSOC);	
     


	 if ($valor_viejo['descripcion_adquisicion'] <> $Descripcion) {
       
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'MODIFICO', 'LA DESCRIPCION DE ADQUISICION ' . $valor_viejo['descripcion_adquisicion'] . ' POR ' . $Descripcion . ' ');
        /* Hace el query para que actualize*/

        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            echo '<script type="text/javascript">
            swal({
                title:"",
                text: "Los datos se almacenaron correctamente",
                type: "success",
                showConfirmButton: false,
                timer: 6000
              });
              $(".FormularioAjax")[0].reset();
              window.location = "../vistas/editar_detalle_adquisicion_vista.php";
          </script>';
        } else {
            echo '<script type="text/javascript">
           swal({
                title: "",
                text: "Descripcion no actualizada.",
                type: "error",
                showConfirmButton: false,
                timer: 3000
            });
            $(".FormularioAjax")[0].reset();
            window.location = "../vistas/editar_detalle_adquisicion_vista.php";
        </script>';
        }
    } else {
        /*header("location: ../contenidos/editarRoles-view.php?msj=3&Rol=$Rol2 ");*/
        echo '<script type="text/javascript">
        swal({
             title: "",
             text: "Descripcion no actualizada.",
             type: "error",
             showConfirmButton: false,
             timer: 3000
         });
         $(".FormularioAjax")[0].reset();
         window.location = "../vistas/editar_detalle_adquisicion_vista.php";
     </script>';

        } 
}


ob_end_flush();

?>

