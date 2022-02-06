<?php
require_once "../Modelos/plan_estudio_modelo.php";

//var para selecciona la equivalencias
$id_asignatura = isset($_POST["id_asignatura"]) ? limpiarCadena1($_POST["id_asignatura"]) : "";

$id_equivalencia = isset($_POST["id_equivalencia"]) ? limpiarCadena1($_POST["id_equivalencia"]) : "";

// eliminar equivalencia
$eliminar_equivalencia = isset($_POST["eliminar_equivalencia"]) ? limpiarCadena1($_POST["eliminar_equivalencia"]) : "";

$instancia_modelo = new modelo_plan();
switch ($_GET["op"]) {

    case 'id_asignatura':
        $rspta = $instancia_modelo->sel_equivalencias($id_asignatura);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'existe_equivalencias':
        $rspta = $instancia_modelo->existe_equivalencia($id_asignatura, $id_equivalencia);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'insertar_equivalencias':

        $rspta = $instancia_modelo->insertar_equivalencias($id_asignatura, $id_equivalencia);
        echo json_encode($rspta);

        break;
    case 'eliminar_equivalencia':


        $rspta = $instancia_modelo->eliminar_equivalencias($eliminar_equivalencia);

        break;
}
