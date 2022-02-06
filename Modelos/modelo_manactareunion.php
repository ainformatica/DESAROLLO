<?php
ob_start();
session_start();
require_once('../clases/Conexion.php');
$tipo = $_POST['tipo'];
$id_tipo = $_POST['id_tipo'];
if ($_POST['tipo-actareunion'] == 'nuevo') {
    try {
        $stmt = $mysqli->prepare("INSERT INTO tbl_tipo_reunion_acta (tipo) VALUES (?)");
        $stmt->bind_param("s", $tipo);
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
        $id_objetoac = 5013;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'INGRESO';
        $descripcionac= 'Tipo para la reunión/acta con nombre:'.$tipo;
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

if ($_POST['tipo-actareunion'] == 'actualizar') {
    try {
        $stmt = $mysqli->prepare('UPDATE tbl_tipo_reunion_acta SET tipo = ? WHERE id_tipo = ?');
        $stmt->bind_param("si", $tipo, $id_tipo);
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
        $id_objetoac = 5013;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'MODIFICO';
        $descripcionac= 'Tipo para la reunión/acta con nombre:'.$tipo;
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

if ($_POST['tipo-actareunion'] == 'eliminar') {
    $id_borrar = $_POST['id'];

    try {
        $stmt = $mysqli->prepare('DELETE FROM tbl_tipo_reunion_acta WHERE id_tipo = ? ');
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
        $id_objetoac = 5013;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'ELIMINO';
        $descripcionac= 'Tipo para la reunión/acta con id:'.$id_borrar;
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
