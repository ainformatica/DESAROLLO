<?php
ob_start();
session_start();
include_once '../clases/Conexion.php';
$enlace = $_POST['NULL'];
$nacta = $_POST['NULL'];
$id_estado = $_POST['id_recursos'];
$desarrollo = $_POST['NULL'];
$fecha = $_POST['fecha'];
$nacta = $_POST['nacta'];
$desarrollo = $_POST['desarrollo'];
$participante = $_POST['participante'];
$asistencia = $_POST['asistencia'];
$id_reunion = $_POST['id_reunion'];
$fecha_formateada = date('Y-m-d', strtotime($fecha));
$horafinal = $_POST['horafinal'];
$horainicio = $_POST['horainicio'];
$horainiciof = date('H:i;s', strtotime($horainicio));
$id_registro = $_POST['id_registro'];
$redactor = $_SESSION['id_usuario'];
$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d H:i:s");

if ($_POST['acta'] == 'actualizar') {
    try {
        $stmt = $mysqli->prepare('UPDATE tbl_acta SET num_acta =?,hora_inicial=?,hora_final=?,desarrollo=?,redactor=?,fecha_edicion=? WHERE id_acta=?');
        $stmt->bind_param("ssssisi", $nacta, $horainicio, $horafinal, $desarrollo, $redactor, $hoy, $id_registro);
        $stmt->execute();
        foreach ($_REQUEST['asistencia'] as $id_persona => $id_estado_participante) {
            $stmt = $mysqli->prepare(
                "UPDATE tbl_participantes  SET id_estado_participante=? WHERE id_reunion=? AND id_persona=?"
            );
            $stmt->bind_param("iii", $id_estado_participante, $id_reunion, $id_persona);
            $stmt->execute();
        }
       

        //almacenamos las propiedades de las imagenes
        $name_array     = $_FILES['archivo_acta']['name'];
        $tmp_name_array = $_FILES['archivo_acta']['tmp_name'];
        $type_array     = $_FILES['archivo_acta']['type'];
        $size_array     = $_FILES['archivo_acta']['size'];
        $error_array    = $_FILES['archivo_acta']['error'];

        $directorio = "../archivos/archivoactas/actasguardadas/$id_registro/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }
        for ($i = 0; $i < count($tmp_name_array); $i++) {
            if (move_uploaded_file($tmp_name_array[$i], $directorio . $name_array[$i])) {
                $url = $directorio;
                $nombrearchivo = $name_array[$i];
                $formato = pathinfo($nombrearchivo, PATHINFO_EXTENSION);
                $url_resultado = "se subio correctamente";
                $stmt = $mysqli->prepare('INSERT INTO tbl_acta_recursos(id_acta, url, fecha_carga, redactor,nombre,formato) VALUES (?,?,?,?,?,?)');
                $stmt->bind_param("ississ", $id_registro, $url, $hoy, $redactor, $nombrearchivo, $formato);
                $stmt->execute();
                
            } else {
                $respuesta = array(
                    'respuesta' => error_get_last()
                );
            }
        }
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $id_registro,
                'resultado_archivo' => $url_resultado
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5005;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'MODIFICO';
        $descripcionac= 'el acta con número: '.$nacta;
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

if ($_POST['acta'] == 'finalizar') {
    $estado = 3;
    $id_finalizar = $_POST['id'];
    try {
        $stmt = $mysqli->prepare('UPDATE tbl_acta SET id_estado=? WHERE id_acta=?');
        $stmt->bind_param("ii", $estado, $id_finalizar);
        $stmt->execute();
        if ($stmt->affected_rows) {
            $respuesta = array(
                'respuesta' => 'exito',
                'id_actualizado' => $id_finalizar
            );
        } else {
            $respuesta = array(
                'respuesta' => 'error'
            );
        }
        $dtz = new DateTimeZone("America/Tegucigalpa");
        $dt = new DateTime("now", $dtz);
        $hoy = $dt->format("Y-m-d H:i:s");
        $id_objetoac = 5005;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'FINALIZO';
        $descripcionac= 'el acta con número: '.$nacta;
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

if ($_POST['recurso'] == 'borrar') {
    $id_borrar = $_POST['id'];
    try {
        $stmt = $mysqli->prepare(' DELETE FROM tbl_acta_recursos WHERE id_recursos = ?');
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
        $id_objetoac = 5005;
        $id_userac = $_SESSION['id_usuario'];
        $accionac = 'ELIMINO';
        $descripcionac= 'recurso del acta con número: '.$nacta;
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
