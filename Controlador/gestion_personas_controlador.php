<?php
require_once "../Modelos/plan_estudio_modelo.php";

// $id_persona = isset($_POST["id_persona"]) ? limpiarCadena1($_POST["id_persona"]) : "";


$instancia_modelo = new modelo_plan();
switch ($_GET["op"]) {

   

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