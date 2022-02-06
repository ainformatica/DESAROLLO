<?php
require '../Modelos/plan_estudio_modelo.php';

$MU = new modelo_plan();

$nombre = $_POST["nombre"];
$codigo = $_POST["codigo_plan"];


$consulta = $MU->buscar_historial_plan($nombre,$codigo);
if ($consulta) {
    echo json_encode($consulta);
} else {
    echo '{
		    "sEcho": 1,
		    "iTotalRecords": "0",
		    "iTotalDisplayRecords": "0",
		    "aaData": []
		}';
}