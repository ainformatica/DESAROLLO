<?php
require_once "../Modelos/ajustes_perfil_usuario_modelo.php";


$id_usuario = isset($_POST["id_usuario"]) ? limpiarCadena1($_POST["id_usuario"]) : "";

$instancia_modelo = new ajustes_perfil_modelo();
switch ($_GET["op"]) {
    case 'usuario':
        $data = array();
        $respuesta2 = $instancia_modelo->usuario();

        while ($r2 = $respuesta2->fetch_object()) {

            # code...
            echo "<option value='" . $r2->id_usuario . "'> " . $r2->usuario . " </option>";
        }
        break;
    case 'confirmar':
        $rspta = $instancia_modelo->confirmar($id_usuario);
        //Codificar el resultado utilizando json
        echo json_encode($rspta);
        break;
}
