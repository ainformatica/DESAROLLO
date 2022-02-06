<?php
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora_movil.php');


$Id_objeto = 174;
$opcion = $_GET['op'];


if (isset($_POST['funcion'])) {
  if ($_POST['funcion']=='eliminar') {
      $id = (int)$_POST['id'];
              //se ejecuta el sql respectivo
              $sql = "DELETE FROM tbl_movil_tipo_mensajes where id = $id";
              $resultado = $mysqli->query($sql);
              if ($resultado) {
                  echo 'hola mundo';
              }else{
                  echo '';
              }
  }
}


if ($opcion == 'eliminar') {
  $id_tipomensaje= isset($_GET["id"]) ? ($_GET["id"]) : "";
  $sql = "DELETE FROM tbl_movil_tipo_mensajes WHERE id = $id_tipomensaje";
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'ELIMINO', "$sql");
  $resultado = $mysqli->query($sql);
  if($resultado === TRUE){
            echo '<script type="text/javascript">
                swal({
                     title:"",
                     text:"Los datos se eliminaron correctamente",
                     type: "success",
                     showConfirmButton: false,
                     timer: 3000
                  });
                  $(".FormularioAjax")[0].reset();
                                 window.location = "../vistas/movil_mantenimiento_tipo_mensaje_vista.php";

              </script>';
          }else{
            echo '<script type="text/javascript">
                      swal({
                         title:"",
                         text:"No se realizo el proceso, el registro a eliminar tiene datos en otras tablas",
                         type: "error",
                         showConfirmButton: false,
                         timer: 3000
                      });
                       $(".FormularioAjax")[0].reset();
                  </script>';
          }
}elseif ($opcion == 'editar') {
  $id_tipomensaje = isset($_GET["id"]) ? ($_GET["id"]) : "";
  $tipo_mensaje = isset($_POST["tipo_mensaje"]) ? strtoupper($_POST["tipo_mensaje"]) : "";
  $sql="UPDATE tbl_movil_tipo_mensajes set tipo_mensaje= '$tipo_mensaje' WHERE id = $id_tipomensaje";
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'MODIFICO', 'EL TIPO MENSAJE' . $tipo_mensaje . '');
  $mysqli->query($sql);
  header('location: ../vistas/movil_mantenimiento_tipo_mensaje_vista.php?msj=2');
}else{
  $tipo_mensaje = isset($_POST["tipo_mensaje"]) ? strtoupper($_POST["tipo_mensaje"]) : "";
  
  


///Logica para el que se repite
$sqlexiste = ("select count(tipo_mensaje) as tipo_mensaje from tbl_movil_tipo_mensajes where tipo_mensaje='$tipo_mensaje'");
//Obtener la fila del query
$existe = mysqli_fetch_assoc($mysqli->query($sqlexiste));



/* Logica para que no acepte campos vacios */
if ($_POST['tipo_mensaje']  ) {

  /* Condicion para que no se repita el rol*/
  if ($existe['tipo_mensaje'] == 1) {
    //redireccion ya que el nombre segmento existe
 	header('location: ../vistas/movil_mantenimiento_tipo_mensaje_vista.php?msj=1'); 
    
  } else {

    /* Query para que haga el insert*/
    $sql = "INSERT into tbl_movil_tipo_mensajes (id,tipo_mensaje) VALUES (null,'$tipo_mensaje')";
    $resultado = $mysqli->query($sql);


    if ($resultado) {
      bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INSERTO', "$sql");

      header('location: ../vistas/movil_mantenimiento_tipo_mensaje_vista.php?msj=2');
    } else {
      echo "Error: " . $sql;
    }
  }
} else {
  header('location: ../vistas/movil_mantenimiento_tipo_mensaje_vista.php?msj=3');
}

}
ob_end_flush();