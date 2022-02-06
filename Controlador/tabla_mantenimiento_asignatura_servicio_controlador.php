<?php
require '../Modelos/plan_estudio_modelo.php';

$MU = new modelo_plan();


$consulta = $MU->listar_asignaturas_servicio();
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
