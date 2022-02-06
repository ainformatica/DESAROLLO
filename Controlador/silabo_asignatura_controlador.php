<?php
require_once "../Modelos/plan_estudio_modelo.php";
$MP = new modelo_plan();

$nombrearchivo2 = isset($_POST["nombrearchivo"]) ? limpiarCadena1($_POST["nombrearchivo"]) : "";


if (is_array($_FILES) && count($_FILES) > 0) {

    if (empty($Id_asignatura)) {
        if (move_uploaded_file($_FILES["c"]["tmp_name"], "../silabos_asignaturas/" . $_FILES["c"]["name"])) {
            $nombrearchivo2 = '../silabos_asignaturas/' . $_FILES["c"]["name"];
            $consulta = $MP->Registrar_silabo_asignatura($nombrearchivo2);
            echo $consulta;
        } else {
            echo 0;
        }

       
    }



    
} else {
    echo 0;
}
