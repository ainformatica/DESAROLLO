<?php
require_once "../Modelos/plan_estudio_modelo.php";
$MP = new modelo_plan();

$nombrearchivo2 = isset($_POST["nombrearchivo2"]) ? limpiarCadena1($_POST["nombrearchivo2"]) : "";
$Id_asignatura = isset($_POST["Id_asignatura"]) ? limpiarCadena1($_POST["Id_asignatura"]) : "";

if (is_array($_FILES) && count($_FILES) > 0) {


       
        if (move_uploaded_file($_FILES["c"]["tmp_name"], "../silabos_asignaturas/" . $_FILES["c"]["name"])) {
            $nombrearchivo2 = '../silabos_asignaturas/' . $_FILES["c"]["name"];
            $consulta = $MP->Actualizar_silabo_asignatura($nombrearchivo2, $Id_asignatura);
            echo $consulta;
        } else {
            echo 0;
        }
    
} else {
    echo 0;
}
