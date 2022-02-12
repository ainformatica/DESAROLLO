<?php
require_once "../Modelos/plan_estudio_modelo.php";

$nombre_plan = isset($_POST["nombre"]) ? limpiarCadena1($_POST["nombre"]) : "";



$instancia_modelo = new modelo_plan();
switch ($_GET["op"]) {

    case 'genero':

        $data = array();
        $respuesta2 = $instancia_modelo->genero();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_genero . "'> " . $r2->genero . " </option>";
        }
        break;

    case 'tipo_persona':

        $data = array();
        $respuesta2 = $instancia_modelo->tipo_persona();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_tipo_persona . "'> " . $r2->tipo_persona . " </option>";
        }
        break;
    }

?>