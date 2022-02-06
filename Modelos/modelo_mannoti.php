<?php
include_once '../clases/Conexion.php';
$estado = $_POST['estado'];
$id_estado = $_POST['id_estado'];
if ($_POST['estado-noti'] == 'nuevo') {
    try {
        $stmt = $mysqli->prepare("INSERT INTO tbl_estado_notificacion (estado) VALUES (?)");
        $stmt->bind_param("s", $estado);
        $stmt->execute();
        $id_registro = $stmt->insert_id;
        if ($id_registro > 0) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_registro' => $id_registro
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        } 
        $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5017;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'INSERTO';
        $descripcionac= 'estado para unA NOTIFICACION con nombre:'.$estado;
        $fechaac = $hoy;
        $stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    die(json_encode($respuesta));
}

if ($_POST['estado-noti'] == 'actualizar') {
    try {
        $stmt = $mysqli->prepare('UPDATE tbl_estado_notificacion SET estado = ? WHERE id_estado_notificacion = ?');
        $stmt->bind_param("si", $estado, $id_estado);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $stmt->insert_id
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5017;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'MODIFICO';
        $descripcionac= 'estado para unA NOTIFICACION con nombre:'.$estado;
        $fechaac = $hoy;
        $stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => 'error'
        );
    }
    die(json_encode($respuesta));
}

if ($_POST['estado-noti'] == 'eliminar') {
    $id_borrar = $_POST['id'];
    try {
        $stmt = $mysqli->prepare('DELETE FROM tbl_estado_notificacion WHERE id_estado_notificacion = ? ');
        $stmt->bind_param('i', $id_borrar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_eliminado' => $id_borrar
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5017;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'ELIMINO';
        $descripcionac= 'estado para unA NOTIFICACION con id:'.$id_borrar;
        $fechaac = $hoy;
        $stmt = $mysqli->prepare("INSERT INTO `tbl_bitacora` (`Id_usuario`, `Id_objeto`, `Fecha`, `Accion`, `Descripcion`) VALUES (?,?,?,?,?)");
        $stmt->bind_param("iisss", $id_userac, $id_objetoac, $fechaac, $accionac, $descripcionac);
        $stmt->execute();
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}