<?php
require_once('../clases/Conexion.php');

if (isset($_POST['tipo_recursos'])) { //!insert en la tabla de recursos
    $estado = 'Activo';
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_recurso'];
    $nombre_recurso = $_POST['nombre_recurso'];
    $respuesta = $mysqli->query("INSERT INTO tbl_recursos_tipo (descripcion,fecha, nombre_recurso,estado) VALUES ('$descripcion', '$fecha', '$nombre_recurso', '$estado')");
    var_dump($respuesta);
    if ($respuesta == true) {
        echo json_encode('exito');
    } else {
        echo json_encode('error');
    }
}

if (isset($_POST['accion']) == "tabla_recursos") { //!tabla de los tipos de recursos
    $result = $mysqli->query("SELECT id_recurso_tipo,nombre_recurso,descripcion,fecha,estado FROM  tbl_recursos_tipo ");
    $filas = array();
    while ($fila = mysqli_fetch_assoc($result)) {
        $filas[] = $fila;
    }
    echo json_encode($filas); //enviando en formato jSON
    mysqli_free_result($result); //libera el resultado de la Bd.
}

if (isset($_POST['eliminar_recurso'])) {
    $id_recurso = $_POST['id'];
    $respuesta = $mysqli->query("DELETE FROM `tbl_recursos_tipo` WHERE `tbl_recursos_tipo`.`id_recurso_tipo` =$id_recurso ");
    if ($respuesta == true) {
        echo json_encode('exito');
    } else {
        echo json_encode('error');
    }
}

if (isset($_POST['cambiar_estado'])) {
    $estado = $_POST['estado'];
    $id = $_POST['id'];
    if ($estado == 'Activo') {
        $nuevo_estado = 'Inactivo';
        //$respuesta = $db->cambiarEstado($id, $nuevo_estado);
        $respuesta = $mysqli->query("UPDATE tbl_recursos_tipo set estado = $nuevo_estado WHERE id_recurso_tipo = $id");
        if ($respuesta == true) {
            echo json_encode('exito');
        } else {
            echo json_encode('error');
        }
        echo json_encode($respuesta);
    } else if ($estado == 'Inactivo') {
        $nuevo_estado = 'Activo';
        //$respuesta = $db->cambiarEstado($id, $nuevo_estado);
        $respuesta = $mysqli->query("UPDATE tbl_recursos_tipo set estado = $nuevo_estado WHERE id_recurso_tipo = $id");
        if ($respuesta == true) {
            echo json_encode('exito');
        } else {
            echo json_encode('error');
        }
        echo json_encode($respuesta);
    }
}
