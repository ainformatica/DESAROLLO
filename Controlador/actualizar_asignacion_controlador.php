<?php

session_start();

ob_start();

require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_permisos.php');


$Id_objeto = 212;
$id_asignacion = $_GET['id_asignacion'];
$id_usuario = $_SESSION['id_usuario'];
$id_detalle = $_SESSION['id_detalle'];
$id_usuario_responsable_previo = $_SESSION['id_usuario_responsable_previo'];
$id_usuario_responsable = $_POST['txt_nueva_persona_responsable'];
$motivo_previo = mb_strtoupper($_SESSION['motivo_previo']);
$motivo = mb_strtoupper($_POST['motivo_reasignacion_modal']);
$id_ubicacion_previa = $_SESSION['id_ubicacion'];
$id_ubicacion = $_POST['cmb_ubicacion_modal'];
$fecha_asignacion_previa = $_POST['txt_fecha_modal'];
$fecha_asignacion = $_POST['nueva_fecha_asignacion'];
$inventario = $_POST['txt_inventario_modal'];



 if  ($_POST['motivo_reasignacion_modal']<> '' and $_POST['txt_nueva_persona_responsable']<> '' and $_POST['cmb_ubicacion_modal']> 0)
 
{


            $sql = "SELECT CONCAT(nombres, ' ', apellidos) as nombre from tbl_personas where id_persona=$id_usuario_responsable";
            $resultado = $mysqli->query($sql);
            $row = $resultado->fetch_array(MYSQLI_ASSOC);
            $nombre=$row['nombre'];

            $sql = "SELECT  ubicacion as ubicacion from tbl_ubicacion where id_ubicacion=$id_ubicacion";
            $resultado = $mysqli->query($sql);
            $row = $resultado->fetch_array(MYSQLI_ASSOC);
            $ubicacion=$row['ubicacion'];


    $sql = "CALL proc_actualizar_asignacion('$id_asignacion', '$id_usuario', '$id_usuario_responsable_previo', '$id_usuario_responsable', '$motivo_previo', '$motivo', '$id_ubicacion_previa', '$id_ubicacion', '$fecha_asignacion_previa', '$fecha_asignacion')";
 
    
    if ($id_usuario_responsable_previo <> $id_usuario_responsable and $id_ubicacion_previa<>$id_ubicacion) {

       
        bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'REASIGNO ', 'EL ELEMENTO DE INVENTARIO: ' . $inventario . ' A LA PERSONA ' . $nombre. ' EN LA UBICACION ' . $ubicacion . '');

        /* Hace el query para actualizar*/
        $resultado = $mysqli->query($sql);

        if ($resultado == true) {
            header("location:../vistas/gestion_asignacion_vista.php?msj=2");
        } else {
            header("location:../vistas/gestion_asignacion_vista.php?msj=3");
        }
 
  }

elseif($id_ubicacion_previa<>$id_ubicacion) {

       
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'REASIGNO ', 'EL ELEMENTO DE INVENTARIO: ' . $inventario . ' EN LA UBICACION ' . $ubicacion . '');

    /* Hace el query para actualizar*/
    $resultado = $mysqli->query($sql);

    if ($resultado == true) {
        header("location:../vistas/gestion_asignacion_vista.php?msj=2");
    } else {
        header("location:../vistas/gestion_asignacion_vista.php?msj=3");
    }

}

elseif ($id_usuario_responsable_previo <> $id_usuario_responsable ) {

       
    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'REASIGNO ', 'EL ELEMENTO DE INVENTARIO: ' . $inventario . ' A LA PERSONA ' . $nombre. '');

    /* Hace el query para actualizar*/
    $resultado = $mysqli->query($sql);

    if ($resultado == true) {
        header("location:../vistas/gestion_asignacion_vista.php?msj=2");
    } else {
        header("location:../vistas/actualizar_asignacion_vista.php?msj=2");
    }

}else{

    header("location:../vistas/actualizar_asignacion_vista.php?msj=3");

}


}else{




    header("location:../vistas/actualizar_asignacion_vista.php?msj=1");
}


ob_end_flush()
    ?>