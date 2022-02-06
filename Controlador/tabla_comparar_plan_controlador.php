<?php
require '../Modelos/plan_estudio_modelo.php';

$MU = new modelo_plan();

$nombre = $_POST["nombre"];

$consulta = $MU->comparar_historial_plan($nombre);
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