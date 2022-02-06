<?php
if(!isset($_SESSION)){ 
  session_start();
}
ob_start();
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora_movil.php');


$Id_objeto = 170;
$opcion = isset($_GET['op']) ? $_GET['op'] : '';


if ($opcion == 'eliminar') {
  $id_parametros= isset($_GET["id"]) ? ($_GET["id"]) : "";
  $sql = "DELETE FROM tbl_movil_parametros WHERE id = $id_parametros";
  $elimino = $mysqli->real_escape_string($sql);
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'ELIMINO', "$elimino");
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
                  </script>';
          }
}elseif ($opcion == 'editar') {
  //funcionalidad para ejecutar el update
  $id_parametros= isset($_GET["id"]) ? ($_GET["id"]) : "";
  $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
  $usuario_mod = $_SESSION['id_usuario'];
  if (!empty($valor) and $valor != 0 ) {
    $sql = "UPDATE tbl_movil_parametros set  valor= '$valor', fecha_modificacion = sysdate(), modificado_por = '$usuario_mod' WHERE id = $id_parametros";
    $actualizar = $mysqli->real_escape_string($sql);
  $mysqli->query($sql);
  bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'MODIFICO', "$actualizar");
  header('location: ../vistas/movil_gestion_parametros_vista.php?msj=2');
  }else{
    header("location: ../vistas/movil_gestion_parametros_vista.php?id=$id_parametros&msj=5");
  }

  
}else{//inicio else
  //se almacenan los valores para realizar el insert
  $parametro = isset($_POST["parametro"]) ? strtoupper($_POST["parametro"]) : "";
  $descripcion = isset($_POST["descripcion"]) ? strtoupper($_POST["descripcion"]) : "";
  $valor = isset($_POST["valor"]) ? $_POST["valor"] : "";
  $usuario_id = isset($_SESSION['id_usuario']) ? ($_SESSION['id_usuario']) : "";
  
/* Logica para que no acepte campos vacios */
    if( !empty($_POST['valor']) and ($_POST['valor'] != 0 or $_POST['valor'] != '0')){
      if (!empty($_POST['parametro']) and  !empty($_POST['descripcion'])) {
    
        /* Query para que haga el insert*/
        //query para traer el nombre del usuario que creo el parametro
        $nombreUser ="SELECT Usuario FROm tbl_usuarios where Id_usuario = $usuario_id";
        $resultado_nombre = $mysqli->query($nombreUser);
        $nombre = $resultado_nombre->fetch_assoc();
        $user = $nombre['Usuario'];
        $sql = "INSERT into tbl_movil_parametros (parametro,descripcion,valor,fecha_modificacion,creado_por,modificado_por) VALUES ('$parametro', '$descripcion', '$valor',sysdate(),'$user',$usuario_id)";
        $resultado = $mysqli->query($sql);
        bitacora_movil::evento_bitacora($_SESSION['id_usuario'], $Id_objeto, 'INSERTO',strtoupper("$sql"));
        if ($resultado) {//-----------------------
          header('location: ../vistas/movil_gestion_parametros_vista.php?msj=2');
        } else {
          echo "Error: " . $sql;
        }//-------------------------------

      } else {
      header('location: ../vistas/movil_gestion_parametros_vista.php?msj=3');
      }
    } else {
      header('location: ../vistas/movil_crear_parametros_vista.php?msj=5');
    }
}//fin else

ob_end_flush();