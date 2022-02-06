<?php
require_once "../Modelos/personas_modelo.php";

$instancia_modelo=new personas();


$cuenta = isset($_POST["cuenta"]) ? ($_POST["cuenta"]) : "";

switch ($_GET["op"]){
	case 'Tipopersona':

        $data = array();
        $respuesta2 = $instancia_modelo->listar_tipo_persona();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_tipo_persona . "'> " . $r2->tipo_persona . " </option>";
        }
        break;

    case 'genero':

        $data = array();
        $respuesta2 = $instancia_modelo->listar_genero();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_genero . "'> " . $r2->genero . " </option>";
        }
        break;

    case 'estado_civil':

        $data = array();
        $respuesta2 = $instancia_modelo->listar_estado_civil();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_estado_civil . "'> " . $r2->estado_civil . " </option>";
        }
        break;

    case 'nacionalidad':

        $data = array();
        $respuesta2 = $instancia_modelo->listar_nacionalidad();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_nacionalidad . "'> " . $r2->nacionalidad . " </option>";
        }
        break;

    case 'verificarPersona':
        $rspta = $instancia_modelo->existe_persona($cuenta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;

    case 'verificarPersonaAdmin':
        $rspta = $instancia_modelo->existe_personaAdmin($cuenta);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;




	
	
}





