<?php
ob_start();
session_start();
include_once '../clases/Conexion.php';
$redactor = $_SESSION['id_usuario'];
$nombre = $_POST['nombre'];
$tipo = $_POST['tipo'];
$lugar = $_POST['lugar'];
$fecha = $_POST['fecha'];
$nacta = $_POST['nacta'];
$fecha_formateada = date('Y-m-d', strtotime($fecha));
$horafinal = $_POST['horafinal'];
$horainicio = $_POST['horainicio'];
$horainiciof = date('H:i;s', strtotime($horainicio));
$redactor = $_SESSION['id_usuario'];
$dtz = new DateTimeZone("America/Tegucigalpa");
$dt = new DateTime("now", $dtz);
$hoy = $dt->format("Y-m-d H:i:s");

if ($_POST['acta'] == 'actualizar') {
    
    try {
        //almacenamos las propiedades del documento
        $name_array     = $_FILES['archivo_acta']['name'];
        $tmp_name_array = $_FILES['archivo_acta']['tmp_name'];
        $type_array     = $_FILES['archivo_acta']['type'];
        $size_array     = $_FILES['archivo_acta']['size'];
        $error_array    = $_FILES['archivo_acta']['error'];

        $directorio = "../archivos/archivoactas/actasarchivadas/$nacta/";
        if (!is_dir($directorio)) {
            mkdir($directorio, 0755, true);
        }
        for ($i = 0; $i < count($tmp_name_array); $i++)  {
            if (move_uploaded_file($tmp_name_array[$i], $directorio . $name_array[$i])) {
                $url = $directorio;
                $nombrearchivo = $name_array[$i];
                $formato = pathinfo($nombrearchivo, PATHINFO_EXTENSION);
                $url_resultado = "se subio correctamente";
                $stmt = $mysqli->prepare('INSERT INTO tbl_acta_archivo(nombrereu,id_tipo, num_acta, fecha,fecha_archivo, redactor, url, nombre) VALUES (?,?,?,?,?,?,?,?)');
                $stmt->bind_param("sisssiss", $nombre, $tipo, $nacta, $fecha_formateada, $hoy, $redactor, $url, $nombrearchivo);
                $stmt->execute();
            } else {
                $respuesta = array(
                    'respuesta' => error_get_last()
                );
            }
        }
        if ($_POST['tipo'] = '' or $_POST['tipo'] = 'NULL')  {
            $respuesta = array(
                'respuesta' => 'exito',
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
        $accionac = 'ARCHIVO';
        $descripcionac= 'acta con número: '.$nacta;
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
/*
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
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => 'error'
        );
    }
    die(json_encode($respuesta));
}
*/

/*
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
        $stmt->close();
        $mysqli->close();
    } catch (Exception $e) {
        $respuesta = array(
            'respuesta' => $e->getMessage()
        );
    }
    die(json_encode($respuesta));
}
*/